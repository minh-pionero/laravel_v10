<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    public function getDirectory()
    {
        function getAllFileAndFolder($directory)
        {
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $pathFiles = [];
            $readDirectory = scandir($directory);
            $keyFile = 0;

            foreach ($readDirectory as $item) {
                if ($item === '..' || $item === '.') continue;

                $path = $directory . '/' . $item;

                if (is_dir($path)) {
                    array_push($pathFiles, [
                        'key' => Str::random(30),
                        'title' => $item,
                        'path' => $path,
                        'children' => getAllFileAndFolder($path),
                    ]);
                } else {
                    $url = env('APP_URL');
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), $imageExtensions);

                    array_push($pathFiles, [
                        'key' => Str::random(30),
                        'title' => $item,
                        'url' => $url . $path,
                        'path' => $path,
                        'isImage' => $isImage,
                    ]);
                }

                $keyFile += 1;
            }

            return $pathFiles;
        }

        $directoryRoot = env('ROOT_UPLOAD_DIRECTORY');

        if (is_dir($directoryRoot)) {
            return response()->json([
                'data' => getAllFileAndFolder($directoryRoot, '0')
            ]);
        } else {
            mkdir($directoryRoot, 0777, true);
            return response()->json([
                'data' => []
            ]);
        }
    }

    public function storeFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|max:2048',
                'filePath' => 'required|string'
            ]);
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $path = $request->filePath;
            $pathFile = $path . '/' . $fileName;

            if (File::exists($pathFile)) {
                throw new Exception('This file is exists');
            }

            $result = $request->file->move(public_path($path), $fileName);
            $fileUrl = env('APP_URL') . $pathFile;
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($pathFile, PATHINFO_EXTENSION);
            $isImage = in_array(strtolower($extension), $imageExtensions);

            return response()->json([
                'data' => [
                    'key' => Str::random(30),
                    'fileUrl' => $fileUrl,
                    'fileName' => $fileName,
                    'path' =>  $pathFile,
                    'result' => $result,
                    'isImage' => $isImage
                ]
            ]);
        } catch (ValidationException $error) {
            return response()->json($error);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    public function createFolder(Request $request)
    {
        try {
            $request->validate([
                'folderName' => 'required|string',
                'folderPath' => 'required|string'
            ]);
            $folderName = $request->folderName;
            $path = $request->folderPath . '/' . $folderName;

            $dirPath = public_path($path);
            if (!file_exists($dirPath)) {
                mkdir($dirPath, 0777, true);
            } else {
                throw new Exception('This folder is exists');
            }

            return response()->json([
                'data' => [
                    'key' => Str::random(30),
                    'folderName' => $folderName,
                    'folderPath' => $path
                ]
            ]);
        } catch (ValidationException $error) {
            return response()->json($error);
        } catch (Exception $error) {
            return response()->json(['message' => $error->getMessage()]);
        }
    }

    public function renameFileAndFolder(Request $request)
    {
        try {
            $request->validate([
                'oldName' => 'required|string',
                'newName' => 'required|string'
            ]);
            $oldName = $request->oldName;
            $newName = $request->newName;

            if (file_exists(public_path($oldName)) && !file_exists(public_path($newName))) {
                rename($oldName, $newName);
            } else {
                return response()->json(['message' => 'This folder/file is exists']);;
            }

            return response()->json(['message' => 'Update successful']);
        } catch (ValidationException $error) {
            return response()->json(['message' => 'Validate error']);
        }
    }

    public function deleteFileAndFolder(Request $request)
    {
        try {
            $request->validate([
                'path' => 'required|string',
                'isFolder' => 'required|bool'
            ]);
            $path = $request->path;
            $isFolder = $request->isFolder;

            if (file_exists(public_path($path))) {
                if ($isFolder) {
                    File::deleteDirectory($path);
                } else {
                    unlink($path);
                }
            }

            return response()->json(['message' => 'Delete successful']);
        } catch (ValidationException $error) {
            return response()->json(['message' => 'Validate error']);
        }
    }
}
