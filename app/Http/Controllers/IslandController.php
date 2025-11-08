<?php

namespace App\Http\Controllers;

use App\Models\Island;

class IslandController extends Controller
{
    public function landing()
    {
        $islands = Island::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $carouselData = $islands->map(function (Island $island) {
            return [
                'place'       => $island->place_label,
                'title'       => $island->title,
                'title2'      => $island->subtitle,
                'description' => $island->short_description,
                'image'       => $island->image_url,
                'slug'        => $island->slug,
            ];
        });

        return view('landing', [
            'carouselData'   => $carouselData,
            'selectedIsland' => null,
            'featuresByType' => [], // kosong di landing awal
        ]);
    }

    public function show(Island $island)
    {
        abort_unless($island->is_active, 404);

        $islands = Island::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        $carouselData = $islands->map(function (Island $item) {
            return [
                'place'       => $item->place_label,
                'title'       => $item->title,
                'title2'      => $item->subtitle,
                'description' => $item->short_description,
                'image'       => $item->image_url,
                'slug'        => $item->slug,
            ];
        });

        // load semua features yang terkait pulau ini
        $island->load('features');

        $featuresByType = [
            'history'     => $island->features->where('type', 'history')->sortBy('order'),
            'destination' => $island->features->where('type', 'destination')->sortBy('order'),
            'food'        => $island->features->where('type', 'food')->sortBy('order'),
            'culture'     => $island->features->where('type', 'culture')->sortBy('order'),
        ];

        return view('landing', [
            'carouselData'   => $carouselData,
            'selectedIsland' => $island,
            'featuresByType' => $featuresByType,
        ]);
    }
}
