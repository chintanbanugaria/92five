<?php
/**
 * DateAndTime Class.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class Fileupload{

	/**
	 * Uploads a file
	 *
	 */
	public static function upload($file, $parentId, $parentType, $userId)
	{	
		try
		{

			if($parentType == 'project')
			{
				$folder = \Project::where('id','=',$parentId)->get(array('project_name','folder'));
				$destinationPath = 'assets/uploads/projects/'.$folder[0]['folder'].'/';
				$filename = $file->getClientOriginalName();
				$bytes = $file->getSize();
				$size = static::formatSizeUnits($bytes);
				$filemd5 = md5($filename. new \ExpressiveDate. time());
				$extension =$file->getClientOriginalExtension();
				$newfilename  = $filemd5.".{$extension}";
				$fileObj = new \Files;
				$fileObj->file_name = $filename;
				$fileObj->size = $size;
				$fileObj->file_sys_ref = $destinationPath;
				$fileObj->uploaded_by = $userId;
				$fileObj->uploaded_date = date('Y-m-d H:i:s');
				$fileObj->file_md5 = $newfilename;
				$fileObj->key = $filemd5;
				$fileObj->save();
				$fileref_id = $fileObj->id;
				$fileref = new \Fileref;
				$fileref->attachment_id = $fileref_id;
				$fileref->parent_id = $parentId;
				$fileref->parent_type = 'project';
				$fileref->save();
				$upload_success = \Input::file('file')->move($destinationPath, $newfilename);
				return \Response::json('success', 200);
		 	}
		 	if($parentType == 'task')
			{
			 
				$folder = \Task::where('id','=',$parentId)->get(array('name','folder'));
				$destinationPath = 'assets/uploads/tasks/'.$folder[0]['folder'].'/';
				$filename = $file->getClientOriginalName();
				$bytes = $file->getSize();
				$size = static::formatSizeUnits($bytes);
				$filemd5 = md5($filename. new \ExpressiveDate. time());
				$extension =$file->getClientOriginalExtension();
				$newfilename  = $filemd5.".{$extension}";
				$fileObj = new \Files;
				$fileObj->file_name = $filename;
				$fileObj->size = $size;
				$fileObj->file_sys_ref = $destinationPath;
				$fileObj->uploaded_by = $userId;
				$fileObj->uploaded_date = date('Y-m-d H:i:s');
				$fileObj->file_md5 = $newfilename;
				$fileObj->key = $filemd5;
				$fileObj->save();
				$fileref_id = $fileObj->id;
				$fileref = new \Fileref;
				$fileref->attachment_id = $fileref_id;
				$fileref->parent_id = $parentId;
				$fileref->parent_type = 'task';
				$fileref->save();
				$upload_success = \Input::file('file')->move($destinationPath, $newfilename);
				return \Response::json('success', 200);
		 	}
		}
		catch(Exception $e)
		{
			Log::error('Something went Wrong in Fileupload Class - upload():'.$e->getMessage());
   			return \Response::json('error', 400);
		}
	}
 	/**
 	* Size Conversion
 	* @param string
 	* @return String
 	* @link http://stackoverflow.com/a/5501447
 	*/
	public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
	}
}