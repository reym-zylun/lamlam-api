<?php

use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('destinations')->insert([
            'name_ja'    => 'ホテルニッコーグアム',
            'name_en'    => 'Hotel Nikko Guam',
            'latitude'   => '13.522100',
            'longitude'  => '144.804800',
            'nearest_bus_stop_ids' => 1,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'ロッテホテル',
            'name_en'    => 'Lotte Hotel',
            'latitude'   => '13.520400',
            'longitude'  => '144.807700',
            'nearest_bus_stop_ids' => 2,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'ウェスティンホテル / (リーフ　ホテル)',
            'name_en'    => 'Westin Hotel / (Reef Hotel)',
            'latitude'   => '13.518000',
            'longitude'  => '144.807400',
            'nearest_bus_stop_ids' => 3,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'アウトリガーホテル / ザ・プラザ',
            'name_en'    => 'Outrigger / The Plaza',
            'latitude'   => '13.514800',
            'longitude'  => '144.806200',
            'nearest_bus_stop_ids' => 4,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'サンドキャッスル / ハイアットリジェンシー',
            'name_en'    => 'Sandcastle / Hyatt Regency',
            'latitude'   => '13.511400',
            'longitude'  => '144.805800',
            'nearest_bus_stop_ids' => 5,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'タモンサンズプラザ　前',
            'name_en'    => 'Across Tumon Sands Plaza',
            'latitude'   => '13.509600',
            'longitude'  => '144.805000',
            'nearest_bus_stop_ids' => 6,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'ホリデイリゾート / フィエスタリゾート',
            'name_en'    => 'Holiday Resort / Fiesta Resort',
            'latitude'   => '13.506100',
            'longitude'  => '144.800100',
            'nearest_bus_stop_ids' => 7,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'パシフィック・アイランド・クラブ (PIC)',
            'name_en'    => 'Pacific Island Club',
            'latitude'   => '13.502400',
            'longitude'  => '144.793400',
            'nearest_bus_stop_ids' => 8,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'イパオ公園 / グアム政府観光局',
            'name_en'    => 'Ypao Park / GVB',
            'latitude'   => '13.501400',
            'longitude'  => '144.788700',
            'nearest_bus_stop_ids' => 9,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'グアムヒルトンホテル',
            'name_en'    => 'Guam Hilton',
            'latitude'   => '13.504600',
            'longitude'  => '144.786200',
            'nearest_bus_stop_ids' => 10,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'シェラトンホテル',
            'name_en'    => 'Sheraton Laguna Guam',
            'latitude'   => '13.496600',
            'longitude'  => '144.771300',
            'nearest_bus_stop_ids' => 11,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'オンワードホテル',
            'name_en'    => 'Onward',
            'latitude'   => '13.493894',
            'longitude'  => '144.775604',
            'nearest_bus_stop_ids' => 12,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'グアム・プレミア・アウトレット(GPO)',
            'name_en'    => 'Guam Premier Outlets (GPO)',
            'latitude'   => '13.490000',
            'longitude'  => '144.782900',
            'nearest_bus_stop_ids' => 13,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'パシフィック・アイランド・クラブ (PIC)前',
            'name_en'    => 'Across Pacific Island Club (PIC)',
            'latitude'   => '13.502200',
            'longitude'  => '144.793500',
            'nearest_bus_stop_ids' => 14,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'ファウンテン・プラザ',
            'name_en'    => 'Fountain Plaza',
            'latitude'   => '13.503800',
            'longitude'  => '144.797200',
            'nearest_bus_stop_ids' => 15,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'ホリデイリゾートホテル 前',
            'name_en'    => 'Across Holiday Resort',
            'latitude'   => '13.506400',
            'longitude'  => '144.800900',
            'nearest_bus_stop_ids' => 16,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'パシフィックベイホテル (グランドプラザ)',
            'name_en'    => 'Pacific Bay (Grand Plaza)',
            'latitude'   => '13.508100',
            'longitude'  => '144.803500',
            'nearest_bus_stop_ids' => 17,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'タモン・サンズ・プラザ',
            'name_en'    => 'Tumon Sands Plaza',
            'latitude'   => '13.509200',
            'longitude'  => '144.805700',
            'nearest_bus_stop_ids' => 18,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'ハイアットリージェンシー 前',
            'name_en'    => 'Across Hyatt Regency',
            'latitude'   => '13.511000',
            'longitude'  => '144.805900',
            'nearest_bus_stop_ids' => 19,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'Ｔギャラリア by DFS',
            'name_en'    => 'T Galleria by DFS',
            'latitude'   => '13.513300',
            'longitude'  => '144.806400',
            'nearest_bus_stop_ids' => 20,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'JPスーパーストア',
            'name_en'    => 'JP Super Store',
            'latitude'   => '13.515800',
            'longitude'  => '144.807300',
            'nearest_bus_stop_ids' => 21,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'マイクロネシア・モール (MMall)',
            'name_en'    => 'Micronesia Mall (MMall)',
            'latitude'   => '13.520600',
            'longitude'  => '144.816600',
            'nearest_bus_stop_ids' => 22,
            'valid'      => 1
        ]);

        DB::table('destinations')->insert([
            'name_ja'    => 'パシフィックプレイス・ウェスティンホテル前',
            'name_en'    => 'Pacific Place',
            'latitude'   => '13.517800',
            'longitude'  => '144.807600',
            'nearest_bus_stop_ids' => 23,
            'valid'      => 1
        ]);
        DB::table('destinations')->insert([
            'name_ja'    => 'ザ・ビーチバー',
            'name_en'    => 'The Beach Bar & Culture Park',
            'latitude'   => '13.524500',
            'longitude'  => '144.804400',
            'nearest_bus_stop_ids' => 24,
            'valid'      => 1
        ]);
        DB::table('destinations')->insert([
            'name_ja'    => '恋人岬',
            'name_en'    => 'Two Lovers Point',
            'latitude'   => '13.534792',
            'longitude'  => '144.803111',
            'nearest_bus_stop_ids' => 51,
            'valid'      => 1
        ]);
        DB::table('destinations')->insert([
            'name_ja'    => 'チャモロ・ビレッジ',
            'name_en'    => 'Chamorro Village',
            'latitude'   => '13.477322',
            'longitude'  => '144.752158',
            'nearest_bus_stop_ids' => 52,
            'valid'      => 1
        ]);
        DB::table('destinations')->insert([
            'name_ja'    => 'ハガニア大聖堂バシリカ',
            'name_en'    => 'Dulce Nombre de Maria Cathedral-Basilica',
            'latitude'   => '13.474614',
            'longitude'  => '144.752408',
            'nearest_bus_stop_ids' => 53,
            'valid'      => 1
        ]);
        DB::table('destinations')->insert([
            'name_ja'    => 'デデドの朝市',
            'name_en'    => 'Dededo Flea Market',
            'latitude'   => '13.514544',
            'longitude'  => '144.836325',
            'nearest_bus_stop_ids' => 54,
            'valid'      => 1
        ]);
    }
}
