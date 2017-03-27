<?php

use Illuminate\Database\Seeder;

class BusStopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bus_stops')->insert([
            'id'         => 1,
            'name_ja'    => 'ホテルニッコーグアム',
            'name_en'    => 'Hotel Nikko Guam',
            'latitude'   => '13.522100',
            'longitude'  => '144.804800',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 2,
            'name_ja'    => 'ロッテホテル',
            'name_en'    => 'Lotte Hotel',
            'latitude'   => '13.520407',
            'longitude'  => '144.807809',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 3,
            'name_ja'    => 'ウェスティンホテル / (リーフ　ホテル)',
            'name_en'    => 'Westin Hotel / (Reef Hotel)',
            'latitude'   => '13.517729',
            'longitude'  => '144.807402',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 4,
            'name_ja'    => 'アウトリガーホテル / ザ・プラザ',
            'name_en'    => 'Outrigger / The Plaza',
            'latitude'   => '13.514800',
            'longitude'  => '144.806200',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 5,
            'name_ja'    => 'サンドキャッスル / ハイアットリジェンシー',
            'name_en'    => 'Sandcastle / Hyatt Regency',
            'latitude'   => '13.511365',
            'longitude'  => '144.805894',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 6,
            'name_ja'    => 'タモンサンズプラザ　前',
            'name_en'    => 'Across Tumon Sands Plaza',
            'latitude'   => '13.509569',
            'longitude'  => '144.805072',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 7,
            'name_ja'    => 'ホリデイリゾート / フィエスタリゾート',
            'name_en'    => 'Holiday Resort / Fiesta Resort',
            'latitude'   => '13.506034',
            'longitude'  => '144.800142',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 8,
            'name_ja'    => 'パシフィック・アイランド・クラブ (PIC)',
            'name_en'    => 'Pacific Island Club',
            'latitude'   => '13.502350',
            'longitude'  => '144.793426',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 9,
            'name_ja'    => 'イパオ公園 / グアム政府観光局',
            'name_en'    => 'Ypao Park / GVB',
            'latitude'   => '13.501297',
            'longitude'  => '144.788689',
            'valid'      => 1
        ]);

        // ここまで完了

        DB::table('bus_stops')->insert([
            'id'         => 10,
            'name_ja'    => 'グアムヒルトンホテル',
            'name_en'    => 'Guam Hilton',
            'latitude'   => '13.504600',
            'longitude'  => '144.786200',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 11,
            'name_ja'    => 'シェラトンホテル',
            'name_en'    => 'Sheraton Laguna Guam',
            'latitude'   => '13.496600',
            'longitude'  => '144.771300',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 12,
            'name_ja'    => 'オンワードホテル',
            'name_en'    => 'Onward',
            'latitude'   => '13.493894',
            'longitude'  => '144.775604',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 13,
            'name_ja'    => 'グアム・プレミア・アウトレット(GPO)',
            'name_en'    => 'Guam Premier Outlets (GPO)',
            'latitude'   => '13.490000',
            'longitude'  => '144.782900',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 14,
            'name_ja'    => 'パシフィック・アイランド・クラブ (PIC)前',
            'name_en'    => 'Across Pacific Island Club (PIC)',
            'latitude'   => '13.502200',
            'longitude'  => '144.793500',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 15,
            'name_ja'    => 'ファウンテン・プラザ',
            'name_en'    => 'Fountain Plaza',
            'latitude'   => '13.503800',
            'longitude'  => '144.797200',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 16,
            'name_ja'    => 'ホリデイリゾートホテル 前',
            'name_en'    => 'Across Holiday Resort',
            'latitude'   => '13.506400',
            'longitude'  => '144.800900',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 17,
            'name_ja'    => 'パシフィックベイホテル (グランドプラザ)',
            'name_en'    => 'Pacific Bay (Grand Plaza)',
            'latitude'   => '13.508100',
            'longitude'  => '144.803500',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 18,
            'name_ja'    => 'タモン・サンズ・プラザ',
            'name_en'    => 'Tumon Sands Plaza',
            'latitude'   => '13.509200',
            'longitude'  => '144.805700',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 19,
            'name_ja'    => 'ハイアットリージェンシー 前',
            'name_en'    => 'Across Hyatt Regency',
            'latitude'   => '13.511000',
            'longitude'  => '144.805900',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 20,
            'name_ja'    => 'Ｔギャラリア by DFS',
            'name_en'    => 'T Galleria by DFS',
            'latitude'   => '13.513300',
            'longitude'  => '144.806400',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 21,
            'name_ja'    => 'JPスーパーストア',
            'name_en'    => 'JP Super Store',
            'latitude'   => '13.515800',
            'longitude'  => '144.807300',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 22,
            'name_ja'    => 'マイクロネシア・モール (MMall)',
            'name_en'    => 'Micronesia Mall (MMall)',
            'latitude'   => '13.520600',
            'longitude'  => '144.816600',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 23,
            'name_ja'    => 'パシフィックプレイス・ウェスティンホテル前',
            'name_en'    => 'Pacific Place',
            'latitude'   => '13.517800',
            'longitude'  => '144.807600',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 24,
            'name_ja'    => 'ザ・ビーチバー',
            'name_en'    => 'The Beach Bar & Culture Park',
            'latitude'   => '13.524500',
            'longitude'  => '144.804400',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 51,
            'name_ja'    => '恋人岬',
            'name_en'    => 'Two Lovers Point',
            'latitude'   => '13.534792',
            'longitude'  => '144.803111',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 52,
            'name_ja'    => 'チャモロ・ビレッジ',
            'name_en'    => 'Chamorro Village',
            'latitude'   => '13.477322',
            'longitude'  => '144.752158',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 53,
            'name_ja'    => 'ハガニア大聖堂バシリカ',
            'name_en'    => 'Dulce Nombre de Maria Cathedral-Basilica',
            'latitude'   => '13.474614',
            'longitude'  => '144.752408',
            'valid'      => 1
        ]);

        DB::table('bus_stops')->insert([
            'id'         => 54,
            'name_ja'    => 'デデドの朝市',
            'name_en'    => 'Dededo Flea Market',
            'latitude'   => '13.514544',
            'longitude'  => '144.836325',
            'valid'      => 1
        ]);
    }
}
