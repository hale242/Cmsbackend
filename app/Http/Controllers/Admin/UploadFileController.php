<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EventCategory;
use App\EventGallery;
use App\NewsGallery;

class UploadFileController extends Controller
{
	public function UploadFile(Request $request, $folder)
	{
		$pic_name = $request->file('file')->getClientOriginalName();
		$return['path'] = $request->file->storeAs($folder, $pic_name, 'uploads');
		return $return;
	}
	public function DeleteUploadFile(Request $request, $folder)
	{
		$file_name = $request->file_name;
		$url_temp = public_path('uploads/' . $folder);

		unlink($url_temp . '/' . $file_name);
		return 'success';
	}
	public function DeleteUploadFileEdit(Request $request, $folder)
	{
		$url_temp = public_path('uploads/' . $folder);
		$file_name = $request->file_name;
		$temp = explode('/', $file_name);
		$id = $temp[0];
		$name = $temp[1];

		if ($folder == 'EventGallery') {
			EventGallery::find($id)->delete();
		}
		else if ($folder == 'NewsGallery') {
			NewsGallery::find($id)->delete();
		}

		unlink($url_temp . '/' . $name);

		return 'success';
	}

	public function UploadImage(Request $request, $folder)
	{
		$type = $request->file->extension();
		$return['path'] = $request->file->storeAs($folder, time() . '-' . str_random(5) . '.' . $type, 'uploads');
		$return['extension'] = $type;
		switch ($return['extension']) {
			case 'png':
				$return['link_preview'] = asset('uploads/' . $return['path']);
				break;
			case 'jpg':
				$return['link_preview'] = asset('uploads/' . $return['path']);
				break;
			case 'jpeg':
				$return['link_preview'] = asset('uploads/' . $return['path']);
				break;
			case 'gif':
				$return['link_preview'] = asset('uploads/' . $return['path']);
				break;
			case 'pdf':
				$return['link_preview'] = asset('images/pdf.png');
				break;
			case 'doc':
				$return['link_preview'] = asset('images/word.png');
				break;
			case 'docx':
				$return['link_preview'] = asset('images/word.png');
				break;
			case 'xls':
				$return['link_preview'] = asset('images/excel.png');
				break;
			case 'xlsx':
				$return['link_preview'] = asset('images/excel.png');
				break;
			default:
				$return['link_preview'] = asset('images/file.png');
				break;
		}
		return $return;
	}
}
