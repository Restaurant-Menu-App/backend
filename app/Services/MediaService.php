<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaService
{
    protected array $rules;

    public function storeMedia(array $formData = [])
    {
        try {
            DB::beginTransaction();

            $max_size = env('MAX_FILE_SIZE', 102400);
            $this->rules = [
                'media' => 'mimes:jpg,jpeg,png|max:' . $max_size,
            ];

            $validator = Validator::make($formData, $this->rules);

            if ($validator->fails()) {
                return [
                    'status' => false,
                    'message' => 'Validation failed!',
                    'errors' => $validator->errors(),
                ];
            }

            $file = $formData['media'];
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileNameToStore = $fileName . '_' . time() . '.' . $file->extension();

            $url = $file->storeAs('public/', $fileNameToStore);

            $fileName = $fileName . '.' . $file->extension();

            Storage::move($url, 'public/' . $formData['type'] . '/' . $fileNameToStore); //tmp

            $url = Storage::url('public/' . $formData['type'] . '/' . $fileNameToStore);

            // 2: store media data
            $media = Media::create([
                'name' => $fileName,
                'slug' => $fileNameToStore,
                'url' => $url,
                'ext' => $file->extension(),
                'type' => $formData['type'],
            ]);

            DB::commit();

            return $media;
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'message' => $e->getMessage(),
            ];
        }
    }

    public function storeMultiMedia(array $formData = [])
    {
        try {
            DB::beginTransaction();

            $max_size = env('MAX_FILE_SIZE', 102400);
            $this->rules = [
                'medias.*' => 'mimes:jpg,jpeg,png|max:' . $max_size,
            ];

            $validator = Validator::make($formData, $this->rules);

            if ($validator->fails()) {
                return [
                    'status' => false,
                    'message' => 'Validation failed!',
                    'errors' => $validator->errors(),
                ];
            }

            $medias = [];

            foreach ($formData['medias'] as $media) {

                $file = $formData['media'];
                $fileNameWithExt = $file->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $fileNameToStore = $fileName . '_' . time() . '.' . $file->extension();

                $url = $file->storeAs('public/', $fileNameToStore);

                $fileName = $fileName . '.' . $file->extension();

                Storage::move($url, 'public/' . $formData['type'] . '/' . $fileNameToStore); //tmp

                $url = Storage::url('public/' . $formData['type'] . '/' . $fileNameToStore);

                // 2: store media data
                $media = Media::create([
                    'name' => $fileName,
                    'slug' => $fileNameToStore,
                    'url' => $url,
                    'ext' => $file->extension(),
                    'type' => $formData['type'],
                ]);

                array_push($medias, $media);
            }

            DB::commit();

            return $medias;
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'message' => $e->getMessage(),
            ];
        }
    }
}
