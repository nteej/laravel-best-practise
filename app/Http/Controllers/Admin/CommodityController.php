<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commodity;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CommodityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $commodities = Commodity::with('category')->orderByDesc('base_date')->get();
        $history = History::all();
        return view('admin.commodities.index', compact('commodities', 'history'));
    }

    //
    public function create()
    {
        $history = History::all();
        return view('admin.commodities.create', compact('history'));
    }

    public function uploadFile()
    {
        $history = History::paginate(15);
        return view('admin.commodities.uploads', compact('history'));
    }

    public function upload(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'csv_file' => 'required|file|mimes:csv,txt',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            if ($request->hasFile('csv_file')) {
                $fileName = $request->file('csv_file')->getClientOriginalName();

                // Check if the file has been uploaded before
                if (History::where('file_name', $fileName)->exists()) {
                    return redirect()->back()->with('error', $fileName . ' has already been uploaded.');
                }
                try {
                    $path = $request->file('csv_file')->store('csv_uploads'); // Store the CSV file
                } catch (FileException $e) {
                    throw new \Exception('Error while storing the file.');
                }
                $data = array_map('str_getcsv', file(storage_path('app/' . $path)));
                $header = array_shift($data);


                foreach ($data as $row) {
                    $commodity = new Commodity();
                    $commodity->category_id = isset($row[0]) ? $row[0] : 1;
                    $commodity->item_en = isset($row[1]) ? $row[1] : null;
                    $commodity->item_si = isset($row[2]) ? $row[2] : null;
                    $commodity->item_tm = isset($row[3]) ? $row[3] : null;
                    $commodity->price_from = (isset($row[4]) && $row[4] != null) ? $row[4] : 0.00;
                    $commodity->price_to = (isset($row[5]) && $row[5] != null) ? $row[5] : 0.00;
                    $commodity->base_date = isset($row[6]) ? $row[6] : date('Y-m-d');
                    $commodity->save();
                }
                $record_count = count($data);
                // Store data in the history table
                History::create([
                    'file_name' => $fileName,
                    'rows_imported' => count($data),
                ]);

                return redirect()->back()->with('success', 'CSV file uploaded and ' . $record_count . ' records imported.');
            }
            throw new \Exception('Failed to upload CSV file.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
