<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;

class Vk
{
    public function getItemsCount($response)
    {
        return $response['response']['count'];
    }

    public function getItems(Request $request, $response)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $date_from = (int)date_format(date_create($from),'U');
        $date_to = (int)date_format(date_create($to),'U');

        $arrayOfSlice = [];

        foreach($response['response']['items'] as $_id=>$object)
        {

            if(!$_id) continue;

            $id = $object['id'];
            $post_type = $object['post_type'];
            $date = $object['date'];
            $text = $object['text'];


            $attachments = isset($object['attachments']) ? $object['attachments'] : null;
            $comments = isset($object['comments']['count']) ? $object['comments']['count'] : null;
            $likes = isset($object['likes']['count']) ? $object['likes']['count'] : null;
            $reposts = isset($object['reposts']['count']) ? $object['reposts']['count'] : null;
            $views = isset($object['views']['count']) ? $object['views']['count'] : null;


            if($attachments) {

                $arrayOfAttach = [];

                foreach($attachments as $attach) {
                    $attach_type = $attach['type'];

                    if($attach_type == 'photo')
                    {
                        $attach_photos = $attach['photo'];
                        $arrayOfAttach[] = $this->getAttachedPhotos($attach_photos['sizes']);
                    }
                    elseif($attach_type == 'video')
                    {
                        $attach_video = $attach['video'];
                        $arrayOfAttach[] = $this->getAttachedVideos($attach_video);
                    }


                } // foreach

            } //if

            // пропускаем репосты
            if(!$id) continue;
            if("copy" == $post_type) continue;

            // если дата поста не входит в область from-to, то переходим на следующую итерацию
            if($date > $date_from && $date < $date_to) {

                $arrayOfSlice[] = ['id' => $id,
                    'date' => Carbon::createFromTimestamp($date)->format("d.m.Y H:i:s"),
                    'text' => $text,
                    'attach' => $arrayOfAttach,
                    'views' => $views,
                    'comments' => $comments,
                    'likes' => $likes,
                    'reposts' => $reposts];
            }



        }

        return $arrayOfSlice;
    }

    public function getSumViews($items)
    {
        return array_sum(array_column($items, 'views'));
    }

    public function getSumLikes($items)
    {
        return array_sum(array_column($items, 'likes'));
    }

    public function getSumReposts($items)
    {

        return array_sum(array_column($items, 'reposts'));

    }

    public function getSumComments($items)
    {
        return array_sum(array_column($items, 'comments'));
    }


    protected function getAttachedPhotos($attach)
    {
        $attachedPhotos = [];

        foreach($attach as $item) {


            if($item['type'] == "m") {
                $attachedPhotos['src_small'] = $item['url'];
            }

            if($item['type'] == "p") {
                $attachedPhotos['src'] = $item['url'];
            }

            if($item['type'] == "r") {
                $attachedPhotos['src_big'] = $item['url'];
            }
        }


        return $attachedPhotos;
    }

    protected function getAttachedVideos($attach)
    {
        $attachedVideos = [];

        foreach ($attach['image'] as $item) {

            if($item['width'] == 320) {
                $attachedVideos['video_cover'] = $item['url'];
            }

            if($item['width'] == 720) {
                $attachedVideos['video_cover_big'] = $item['url'];
            }
        }

        $attachedVideos['video_title'] = $attach['title'];

        return $attachedVideos;
    }
}