<?php
    namespace App\Services;

    class FileUploadService
    {
        public function saveImage($path){
            // 画像データが入っていたら、
            if( isset($path)){
                // publicディスク(storage/app/public/)のphotosディレクトリに保存
                $path = $path->store('photos', 'public');
            }
            return $path;
        }

        public function updateImage($user, $path){
            // 新しい画像データが入っていたら、
            if($path){
                // 前の画像データを削除
                \Storage::disk('public')->delete(\Storage::url('$path')); 
            }
            $user->update([
                // ファイル名を保存
                'image' => $path
            ]);
        }
    }