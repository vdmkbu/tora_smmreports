<?php


namespace App\Services;


use App\Project;
use Illuminate\Http\Request;


class VkReportService
{
    protected $vk;
    protected $http;

    public function __construct(Vk $vk, HttpClient $http)
    {
        $this->vk = $vk;
        $this->http = $http;
    }

    public function report(Project $project, Request $request)
    {
        $group_keyword = $project->getGroupKeyword();

        $params = [
            'domain' => $group_keyword,
            'count' => 100,
            'filter' => 'owner',
            'offset' => 0,
        ];

        $response = $this->http->request('wall.get', $params, config('vk.app_key'));


        $items = $this->vk->getItems($request, $response);
        $views = $this->vk->getSumViews($items);
        $likes = $this->vk->getSumLikes($items);
        $reposts = $this->vk->getSumReposts($items);
        $comments = $this->vk->getSumComments($items);

        $data = [
            'views' => $views,
            'likes' => $likes,
            'reposts' => $reposts,
            'comments' => $comments,
            'items' => $items
        ];

        return $data;
    }
}
