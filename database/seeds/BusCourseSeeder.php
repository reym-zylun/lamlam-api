<?php

use Illuminate\Database\Seeder;

class BusCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 1,
            'to_bus_stop_id'      => 2,
            'course'              => json_encode([
                ['latitude' => '13.522100',  'longitude' => '144.804800'],
                ['latitude' => '13.521993',  'longitude' => '144.804801'],
                ['latitude' => '13.521912',  'longitude' => '144.804871'],
                ['latitude' => '13.521904',  'longitude' => '144.805008'],
                ['latitude' => '13.522035',  'longitude' => '144.805303'],
                ['latitude' => '13.522118',  'longitude' => '144.805802'],
                ['latitude' => '13.522168',  'longitude' => '144.806159'],
                ['latitude' => '13.522251',  'longitude' => '144.806542'],
                ['latitude' => '13.522331',  'longitude' => '144.806792'],
                ['latitude' => '13.521782',  'longitude' => '144.807227'],
                ['latitude' => '13.521496',  'longitude' => '144.807418'],
                ['latitude' => '13.521285',  'longitude' => '144.807547'],
                ['latitude' => '13.521097',  'longitude' => '144.807653'],
                ['latitude' => '13.520872',  'longitude' => '144.807738'],
                ['latitude' => '13.520622',  'longitude' => '144.807802'],
                ['latitude' => '13.520407',  'longitude' => '144.807809'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 2,
            'to_bus_stop_id'      => 3,
            'course'              => json_encode([
                ['latitude' => '13.520407',  'longitude' => '144.807809'],
                ['latitude' => '13.520321',  'longitude' => '144.807801'],
                ['latitude' => '13.519793',  'longitude' => '144.807780'],
                ['latitude' => '13.518943',  'longitude' => '144.807661'],
                ['latitude' => '13.518378',  'longitude' => '144.807609'],
                ['latitude' => '13.518339',  'longitude' => '144.807515'],
                ['latitude' => '13.518069',  'longitude' => '144.807434'],
                ['latitude' => '13.517729',  'longitude' => '144.807402'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 3,
            'to_bus_stop_id'      => 4,
            'course'              => json_encode([
                ['latitude' => '13.517729',  'longitude' => '144.807402'],
                ['latitude' => '13.517648',  'longitude' => '144.807546'],
                ['latitude' => '13.516640',  'longitude' => '144.807439'],
                ['latitude' => '13.515910',  'longitude' => '144.807267'],
                ['latitude' => '13.515298',  'longitude' => '144.806811'],
                ['latitude' => '13.514800',  'longitude' => '144.806200'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 4,
            'to_bus_stop_id'      => 5,
            'course'              => json_encode([
                ['latitude' => '13.514800',  'longitude' => '144.806200'],
                ['latitude' => '13.514737',  'longitude' => '144.806193'],
                ['latitude' => '13.514461',  'longitude' => '144.806009'],
                ['latitude' => '13.513986',  'longitude' => '144.805966'],
                ['latitude' => '13.512390',  'longitude' => '144.806159'],
                ['latitude' => '13.511365',  'longitude' => '144.805894'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 5,
            'to_bus_stop_id'      => 6,
            'course'              => json_encode([
                ['latitude' => '13.511365',  'longitude' => '144.805894'],
                ['latitude' => '13.511573',  'longitude' => '144.805998'],
                ['latitude' => '13.511009',  'longitude' => '144.805786'],
                ['latitude' => '13.510427',  'longitude' => '144.805496'],
                ['latitude' => '13.509569',  'longitude' => '144.805072'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 6,
            'to_bus_stop_id'      => 7,
            'course'              => json_encode([
                ['latitude' => '13.509569',  'longitude' => '144.805072'],
                ['latitude' => '13.509095',  'longitude' => '144.804857'],
                ['latitude' => '13.508532',  'longitude' => '144.804320'],
                ['latitude' => '13.508083',  'longitude' => '144.803408'],
                ['latitude' => '13.507697',  'longitude' => '144.802593'],
                ['latitude' => '13.507071',  'longitude' => '144.801692'],
                ['latitude' => '13.506034',  'longitude' => '144.800142'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 7,
            'to_bus_stop_id'      => 8,
            'course'              => json_encode([
                ['latitude' => '13.506034',  'longitude' => '144.800142'],
                ['latitude' => '13.503596',  'longitude' => '144.796622'],
                ['latitude' => '13.502658',  'longitude' => '144.794300'],
                ['latitude' => '13.502350',  'longitude' => '144.793426'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 8,
            'to_bus_stop_id'      => 9,
            'course'              => json_encode([
                ['latitude' => '13.502350',  'longitude' => '144.793426'],
                ['latitude' => '13.502658',  'longitude' => '144.794300'],
                ['latitude' => '13.501738',  'longitude' => '144.791925'],
                ['latitude' => '13.501297',  'longitude' => '144.788689'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 9,
            'to_bus_stop_id'      => 10,
            'course'              => json_encode([
                ['latitude' => '13.501262',  'longitude' => '144.789244'],
                ['latitude' => '13.501354',  'longitude' => '144.788465'],
                ['latitude' => '13.502157',  'longitude' => '144.786673'],
                ['latitude' => '13.502267',  'longitude' => '144.786325'],
                ['latitude' => '13.502501',  'longitude' => '144.786367'],
                ['latitude' => '13.502679',  'longitude' => '144.786516'],
                ['latitude' => '13.502916',  'longitude' => '144.786270'],
                ['latitude' => '13.503253',  'longitude' => '144.786062'],
                ['latitude' => '13.503569',  'longitude' => '144.786009'],
                ['latitude' => '13.503983',  'longitude' => '144.786028'],
                ['latitude' => '13.504204',  'longitude' => '144.786001'],
                ['latitude' => '13.504447',  'longitude' => '144.785949'],
            ]),
        ]);

        // ここまで完了

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 10,
            'to_bus_stop_id'      => 11,
            'course'              => json_encode([
                ['latitude' => '13.504447',  'longitude' => '144.785949'],
                ['latitude' => '13.504001',  'longitude' => '144.785996'],
                ['latitude' => '13.503573',  'longitude' => '144.785982'],
                ['latitude' => '13.503232',  'longitude' => '144.786039'],
                ['latitude' => '13.503241',  'longitude' => '144.786035'],
                ['latitude' => '13.502894',  'longitude' => '144.786246'],
                ['latitude' => '13.502678',  'longitude' => '144.786477'],
                ['latitude' => '13.502544',  'longitude' => '144.786375'],
                ['latitude' => '13.502392',  'longitude' => '144.786318'],
                ['latitude' => '13.502262',  'longitude' => '144.786298'],
                ['latitude' => '13.502334',  'longitude' => '144.785987'],
                ['latitude' => '13.502467',  'longitude' => '144.784921'],
                ['latitude' => '13.502538',  'longitude' => '144.784580'],
                ['latitude' => '13.502707',  'longitude' => '144.784151'],
                ['latitude' => '13.503552',  'longitude' => '144.782688'],
                ['latitude' => '13.503831',  'longitude' => '144.782282'],
                ['latitude' => '13.504008',  'longitude' => '144.782095'],
                ['latitude' => '13.504278',  'longitude' => '144.781867'],
                ['latitude' => '13.504478',  'longitude' => '144.781592'],
                ['latitude' => '13.504539',  'longitude' => '144.781352'],
                ['latitude' => '13.504481',  'longitude' => '144.781195'],
                ['latitude' => '13.504286',  'longitude' => '144.780962'],
                ['latitude' => '13.504081',  'longitude' => '144.780852'],
                ['latitude' => '13.503919',  'longitude' => '144.780878'],
                ['latitude' => '13.503702',  'longitude' => '144.780864'],
                ['latitude' => '13.503434',  'longitude' => '144.780886'],
                ['latitude' => '13.502776',  'longitude' => '144.780994'],
                ['latitude' => '13.497619',  'longitude' => '144.781664'],
                ['latitude' => '13.497739',  'longitude' => '144.774316'],
                ['latitude' => '13.497739',  'longitude' => '144.772366'],
                ['latitude' => '13.497760',  'longitude' => '144.772037'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 11,
            'to_bus_stop_id'      => 12,
            'course'              => json_encode([
                ['latitude' => '13.497760',  'longitude' => '144.772037'],
                ['latitude' => '13.497688',  'longitude' => '144.772349'],
                ['latitude' => '13.497671',  'longitude' => '144.773239'],
                ['latitude' => '13.497692',  'longitude' => '144.774310'],
                ['latitude' => '13.497643',  'longitude' => '144.776095'],
                ['latitude' => '13.497003',  'longitude' => '144.776283'],
                ['latitude' => '13.496773',  'longitude' => '144.776314'],
                ['latitude' => '13.496410',  'longitude' => '144.776246'],
                ['latitude' => '13.495985',  'longitude' => '144.776065'],
                ['latitude' => '13.495713',  'longitude' => '144.775968'],
                ['latitude' => '13.495481',  'longitude' => '144.775970'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 12,
            'to_bus_stop_id'      => 13,
            'course'              => json_encode([
                ['latitude' => '13.495481',  'longitude' => '144.775970'],
                ['latitude' => '13.495708',  'longitude' => '144.776021'],
                ['latitude' => '13.495982',  'longitude' => '144.776118'],
                ['latitude' => '13.496401',  'longitude' => '144.776295'],
                ['latitude' => '13.496774',  'longitude' => '144.776364'],
                ['latitude' => '13.497010',  'longitude' => '144.776332'],
                ['latitude' => '13.497616',  'longitude' => '144.776157'],
                ['latitude' => '13.497590',  'longitude' => '144.779704'],
                ['latitude' => '13.497571',  'longitude' => '144.780476'],
                ['latitude' => '13.497556',  'longitude' => '144.781678'],
                ['latitude' => '13.496594',  'longitude' => '144.781842'],
                ['latitude' => '13.491256',  'longitude' => '144.783125'],
                ['latitude' => '13.490608',  'longitude' => '144.783252'],
                ['latitude' => '13.488842',  'longitude' => '144.783656'],
                ['latitude' => '13.488708',  'longitude' => '144.783037'],
                ['latitude' => '13.488585',  'longitude' => '144.782288'],
                ['latitude' => '13.488577',  'longitude' => '144.781962'],
                ['latitude' => '13.488576',  'longitude' => '144.781600'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 13,
            'to_bus_stop_id'      => 10,
            'course'              => json_encode([
                ['latitude' => '13.488576',  'longitude' => '144.781600'],
                ['latitude' => '13.488525',  'longitude' => '144.781914'],
                ['latitude' => '13.488534',  'longitude' => '144.782299'],
                ['latitude' => '13.488654',  'longitude' => '144.783047'],
                ['latitude' => '13.488797',  'longitude' => '144.783735'],
                ['latitude' => '13.490631',  'longitude' => '144.783318'],
                ['latitude' => '13.491291',  'longitude' => '144.783182'],
                ['latitude' => '13.496586',  'longitude' => '144.781897'],
                ['latitude' => '13.497587',  'longitude' => '144.781725'],
                ['latitude' => '13.502815',  'longitude' => '144.781035'],
                ['latitude' => '13.503448',  'longitude' => '144.780935'],
                ['latitude' => '13.503708',  'longitude' => '144.780909'],
                ['latitude' => '13.503915',  'longitude' => '144.780925'],
                ['latitude' => '13.504080',  'longitude' => '144.780896'],
                ['latitude' => '13.504304',  'longitude' => '144.780907'],
                ['latitude' => '13.504450',  'longitude' => '144.780929'],
                ['latitude' => '13.504587',  'longitude' => '144.780932'],
                ['latitude' => '13.504746',  'longitude' => '144.780919'],
                ['latitude' => '13.504885',  'longitude' => '144.780879'],
                ['latitude' => '13.504992',  'longitude' => '144.780879'],
                ['latitude' => '13.505091',  'longitude' => '144.780906'],
                ['latitude' => '13.505198',  'longitude' => '144.780966'],
                ['latitude' => '13.505240',  'longitude' => '144.781004'],
                ['latitude' => '13.505284',  'longitude' => '144.781075'],
                ['latitude' => '13.505345',  'longitude' => '144.781250'],
                ['latitude' => '13.505334',  'longitude' => '144.781343'],
                ['latitude' => '13.505305',  'longitude' => '144.781451'],
                ['latitude' => '13.505252',  'longitude' => '144.781542'],
                ['latitude' => '13.505160',  'longitude' => '144.781631'],
                ['latitude' => '13.505086',  'longitude' => '144.781672'],
                ['latitude' => '13.504854',  'longitude' => '144.781704'],
                ['latitude' => '13.504661',  'longitude' => '144.781704'],
                ['latitude' => '13.504549',  'longitude' => '144.781720'],
                ['latitude' => '13.504471',  'longitude' => '144.781741'],
                ['latitude' => '13.504247',  'longitude' => '144.781828'],
                ['latitude' => '13.503973',  'longitude' => '144.782062'],
                ['latitude' => '13.503790',  'longitude' => '144.782257'],
                ['latitude' => '13.503495',  'longitude' => '144.782688'],
                ['latitude' => '13.502655',  'longitude' => '144.784147'],
                ['latitude' => '13.502570',  'longitude' => '144.784346'],
                ['latitude' => '13.502487',  'longitude' => '144.784582'],
                ['latitude' => '13.502420',  'longitude' => '144.784913'],
                ['latitude' => '13.502284',  'longitude' => '144.785990'],
                ['latitude' => '13.502201',  'longitude' => '144.786340'],
                ['latitude' => '13.502387',  'longitude' => '144.786356'],
                ['latitude' => '13.502525',  'longitude' => '144.786406'],
                ['latitude' => '13.502685',  'longitude' => '144.786528'],
                ['latitude' => '13.502919',  'longitude' => '144.786281'],
                ['latitude' => '13.503258',  'longitude' => '144.786070'],
                ['latitude' => '13.503575',  'longitude' => '144.786021'],
                ['latitude' => '13.503981',  'longitude' => '144.786036'],
                ['latitude' => '13.503981',  'longitude' => '144.786036'],
                ['latitude' => '13.504447',  'longitude' => '144.785949'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 10,
            'to_bus_stop_id'      => 14,
            'course'              => json_encode([
                ['latitude' => '13.504447',  'longitude' => '144.785949'],
                ['latitude' => '13.504204',  'longitude' => '144.785981'],
                ['latitude' => '13.503981',  'longitude' => '144.786003'],
                ['latitude' => '13.503573',  'longitude' => '144.785986'],
                ['latitude' => '13.503246',  'longitude' => '144.786041'],
                ['latitude' => '13.502900',  'longitude' => '144.786254'],
                ['latitude' => '13.502677',  'longitude' => '144.786482'],
                ['latitude' => '13.502534',  'longitude' => '144.786374'],
                ['latitude' => '13.502394',  'longitude' => '144.786323'],
                ['latitude' => '13.502204',  'longitude' => '144.786298'],
                ['latitude' => '13.502131',  'longitude' => '144.786602'],
                ['latitude' => '13.501317',  'longitude' => '144.788383'],
                ['latitude' => '13.501234',  'longitude' => '144.788675'],
                ['latitude' => '13.501192',  'longitude' => '144.788967'],
                ['latitude' => '13.501209',  'longitude' => '144.789524'],
                ['latitude' => '13.501633',  'longitude' => '144.791750'],
                ['latitude' => '13.501741',  'longitude' => '144.792140'],
                ['latitude' => '13.502401',  'longitude' => '144.793819'],
                ['latitude' => '13.502611',  'longitude' => '144.794312'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 14,
            'to_bus_stop_id'      => 15,
            'course'              => json_encode([
                ['latitude' => '13.502611',  'longitude' => '144.794312'],
                ['latitude' => '13.503248',  'longitude' => '144.795896'],
                ['latitude' => '13.503454',  'longitude' => '144.796450'],
                ['latitude' => '13.503537',  'longitude' => '144.796608'],
                ['latitude' => '13.503829',  'longitude' => '144.797069'],
                ['latitude' => '13.503993',  'longitude' => '144.797312'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 15,
            'to_bus_stop_id'      => 16,
            'course'              => json_encode([
                ['latitude' => '13.503993',  'longitude' => '144.797312'],
                ['latitude' => '13.504318',  'longitude' => '144.797799'],
                ['latitude' => '13.506039',  'longitude' => '144.800284'],
                ['latitude' => '13.506259',  'longitude' => '144.800588'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 16,
            'to_bus_stop_id'      => 17,
            'course'              => json_encode([
                ['latitude' => '13.506259',  'longitude' => '144.800588'],
                ['latitude' => '13.506426',  'longitude' => '144.800863'],
                ['latitude' => '13.507632',  'longitude' => '144.802611'],
                ['latitude' => '13.507898',  'longitude' => '144.803069'],
                ['latitude' => '13.508135',  'longitude' => '144.803569'],
                ['latitude' => '13.508306',  'longitude' => '144.803949'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 17,
            'to_bus_stop_id'      => 18,
            'course'              => json_encode([
                ['latitude' => '13.508306',  'longitude' => '144.803949'],
                ['latitude' => '13.508471',  'longitude' => '144.804263'],
                ['latitude' => '13.508707',  'longitude' => '144.804583'],
                ['latitude' => '13.508892',  'longitude' => '144.804763'],
                ['latitude' => '13.509050',  'longitude' => '144.804885'],
                ['latitude' => '13.510352',  'longitude' => '144.805531'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 18,
            'to_bus_stop_id'      => 19,
            'course'              => json_encode([
                ['latitude' => '13.510352',  'longitude' => '144.805531'],
                ['latitude' => '13.511008',  'longitude' => '144.805816'],
                ['latitude' => '13.511557',  'longitude' => '144.806033'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 19,
            'to_bus_stop_id'      => 20,
            'course'              => json_encode([
                ['latitude' => '13.511557',  'longitude' => '144.806033'],
                ['latitude' => '13.511774',  'longitude' => '144.806111'],
                ['latitude' => '13.512321',  'longitude' => '144.806182'],
                ['latitude' => '13.513638',  'longitude' => '144.806023'],
                ['latitude' => '13.514130',  'longitude' => '144.805987'],
                ['latitude' => '13.514307',  'longitude' => '144.805990'],
                ['latitude' => '13.514460',  'longitude' => '144.806026'],
                ['latitude' => '13.514629',  'longitude' => '144.806107'],
                ['latitude' => '13.514740',  'longitude' => '144.806220'],
                ['latitude' => '13.514784',  'longitude' => '144.806549'],
                ['latitude' => '13.514833',  'longitude' => '144.806577'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 20,
            'to_bus_stop_id'      => 21,
            'course'              => json_encode([
                ['latitude' => '13.514833',  'longitude' => '144.806577'],
                ['latitude' => '13.514902',  'longitude' => '144.806662'],
                ['latitude' => '13.515122',  'longitude' => '144.806668'],
                ['latitude' => '13.515501',  'longitude' => '144.807058'],
                ['latitude' => '13.515673',  'longitude' => '144.807179'],
                ['latitude' => '13.515700',  'longitude' => '144.807215'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 21,
            'to_bus_stop_id'      => 23,
            'course'              => json_encode([
                ['latitude' => '13.515700',  'longitude' => '144.807215'],
                ['latitude' => '13.516043',  'longitude' => '144.807361'],
                ['latitude' => '13.516399',  'longitude' => '144.807446'],
                ['latitude' => '13.517244',  'longitude' => '144.807528'],
                ['latitude' => '13.517537',  'longitude' => '144.807584'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 23,
            'to_bus_stop_id'      => 1,
            'course'              => json_encode([
                ['latitude' => '13.517537',  'longitude' => '144.807584'],
                ['latitude' => '13.518937',  'longitude' => '144.807718'],
                ['latitude' => '13.519810',  'longitude' => '144.807836'],
                ['latitude' => '13.520321',  'longitude' => '144.807858'],
                ['latitude' => '13.520628',  'longitude' => '144.807843'],
                ['latitude' => '13.520888',  'longitude' => '144.807780'],
                ['latitude' => '13.521116',  'longitude' => '144.807682'],
                ['latitude' => '13.521526',  'longitude' => '144.807440'],
                ['latitude' => '13.521806',  'longitude' => '144.807252'],
                ['latitude' => '13.522534',  'longitude' => '144.806674'],
                ['latitude' => '13.522770',  'longitude' => '144.806537'],
                ['latitude' => '13.522998',  'longitude' => '144.806457'],
                ['latitude' => '13.522985',  'longitude' => '144.806414'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 1,
            'to_bus_stop_id'      => 2,
            'course'              => json_encode([
                ['latitude' => '13.522985',  'longitude' => '144.806414'],
                ['latitude' => '13.522757',  'longitude' => '144.806513'],
                ['latitude' => '13.522519',  'longitude' => '144.806649'],
                ['latitude' => '13.521788',  'longitude' => '144.807231'],
                ['latitude' => '13.521498',  'longitude' => '144.807426'],
                ['latitude' => '13.521110',  'longitude' => '144.807659'],
                ['latitude' => '13.520874',  'longitude' => '144.807746'],
                ['latitude' => '13.520618',  'longitude' => '144.807816'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 2,
            'from_bus_stop_id'    => 2,
            'to_bus_stop_id'      => 22,
            'course'              => json_encode([
                ['latitude' => '13.520618',  'longitude' => '144.807816'],
                ['latitude' => '13.520320',  'longitude' => '144.807825'],
                ['latitude' => '13.519793',  'longitude' => '144.807803'],
                ['latitude' => '13.518932',  'longitude' => '144.807684'],
                ['latitude' => '13.517500',  'longitude' => '144.807546'],
                ['latitude' => '13.517388',  'longitude' => '144.807901'],
                ['latitude' => '13.517231',  'longitude' => '144.808288'],
                ['latitude' => '13.516933',  'longitude' => '144.808861'],
                ['latitude' => '13.516665',  'longitude' => '144.809268'],
                ['latitude' => '13.515799',  'longitude' => '144.810337'],
                ['latitude' => '13.515633',  'longitude' => '144.810480'],
                ['latitude' => '13.515408',  'longitude' => '144.810601'],
                ['latitude' => '13.515209',  'longitude' => '144.810664'],
                ['latitude' => '13.514374',  'longitude' => '144.810850'],
                ['latitude' => '13.514290',  'longitude' => '144.810896'],
                ['latitude' => '13.514248',  'longitude' => '144.810955'],
                ['latitude' => '13.514256',  'longitude' => '144.811052'],
                ['latitude' => '13.514374',  'longitude' => '144.811249'],
                ['latitude' => '13.518725',  'longitude' => '144.812240'],
                ['latitude' => '13.519370',  'longitude' => '144.812571'],
                ['latitude' => '13.519835',  'longitude' => '144.812910'],
                ['latitude' => '13.520054',  'longitude' => '144.813148'],
                ['latitude' => '13.520231',  'longitude' => '144.813376'],
                ['latitude' => '13.520389',  'longitude' => '144.813609'],
                ['latitude' => '13.520536',  'longitude' => '144.813881'],
                ['latitude' => '13.520803',  'longitude' => '144.814532'],
                ['latitude' => '13.521476',  'longitude' => '144.816486'],
                ['latitude' => '13.521585',  'longitude' => '144.816762'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 22,
            'to_bus_stop_id'      => 23,
            'course'              => json_encode([
                ['latitude' => '13.521585',  'longitude' => '144.816762'],
                ['latitude' => '13.521505',  'longitude' => '144.816476'],
                ['latitude' => '13.520829',  'longitude' => '144.814516'],
                ['latitude' => '13.520561',  'longitude' => '144.813863'],
                ['latitude' => '13.520420',  'longitude' => '144.813602'],
                ['latitude' => '13.520253',  'longitude' => '144.813348'],
                ['latitude' => '13.520074',  'longitude' => '144.813129'],
                ['latitude' => '13.519858',  'longitude' => '144.812894'],
                ['latitude' => '13.519396',  'longitude' => '144.812552'],
                ['latitude' => '13.518733',  'longitude' => '144.812208'],
                ['latitude' => '13.514392',  'longitude' => '144.811226'],
                ['latitude' => '13.514273',  'longitude' => '144.811003'],
                ['latitude' => '13.514310',  'longitude' => '144.810908'],
                ['latitude' => '13.514384',  'longitude' => '144.810872'],
                ['latitude' => '13.515217',  'longitude' => '144.810692'],
                ['latitude' => '13.515421',  'longitude' => '144.810627'],
                ['latitude' => '13.515647',  'longitude' => '144.810503'],
                ['latitude' => '13.515820',  'longitude' => '144.810357'],
                ['latitude' => '13.516689',  'longitude' => '144.809281'],
                ['latitude' => '13.516961',  'longitude' => '144.808875'],
                ['latitude' => '13.517251',  'longitude' => '144.808310'],
                ['latitude' => '13.517420',  'longitude' => '144.807905'],
                ['latitude' => '13.517537',  'longitude' => '144.807584'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 23,
            'to_bus_stop_id'      => 24,
            'course'              => json_encode([
                ['latitude' => '13.517537',  'longitude' => '144.807584'],
                ['latitude' => '13.518937',  'longitude' => '144.807718'],
                ['latitude' => '13.519810',  'longitude' => '144.807836'],
                ['latitude' => '13.520321',  'longitude' => '144.807858'],
                ['latitude' => '13.520628',  'longitude' => '144.807843'],
                ['latitude' => '13.520888',  'longitude' => '144.807780'],
                ['latitude' => '13.521116',  'longitude' => '144.807682'],
                ['latitude' => '13.521526',  'longitude' => '144.807440'],
                ['latitude' => '13.521806',  'longitude' => '144.807252'],
                ['latitude' => '13.522534',  'longitude' => '144.806674'],
                ['latitude' => '13.522770',  'longitude' => '144.806537'],
                ['latitude' => '13.522998',  'longitude' => '144.806457'],
                ['latitude' => '13.523076',  'longitude' => '144.806431'],
                ['latitude' => '13.523410',  'longitude' => '144.806342'],
                ['latitude' => '13.523667',  'longitude' => '144.806256'],
                ['latitude' => '13.523867',  'longitude' => '144.806147'],
                ['latitude' => '13.524048',  'longitude' => '144.805995'],
                ['latitude' => '13.524194',  'longitude' => '144.805788'],
                ['latitude' => '13.524334',  'longitude' => '144.805535'],
                ['latitude' => '13.524615',  'longitude' => '144.804740'],
                ['latitude' => '13.524707',  'longitude' => '144.804410'], 
                ['latitude' => '13.524738',  'longitude' => '144.804099'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 24,
            'to_bus_stop_id'      => 1,
            'course'              => json_encode([
                ['latitude' => '13.524738',  'longitude' => '144.804099'],
                ['latitude' => '13.524666',  'longitude' => '144.804395'],
                ['latitude' => '13.524573',  'longitude' => '144.804730'],
                ['latitude' => '13.524296',  'longitude' => '144.805520'],
                ['latitude' => '13.524164',  'longitude' => '144.805755'],
                ['latitude' => '13.524019',  'longitude' => '144.805967'],
                ['latitude' => '13.523846',  'longitude' => '144.806110'],
                ['latitude' => '13.523653',  'longitude' => '144.806215'],
                ['latitude' => '13.523388',  'longitude' => '144.806305'],
                ['latitude' => '13.522985',  'longitude' => '144.806414'],
            ]),
        ]);

        DB::table('bus_courses')->insert([
            'bus_id'              => 1,
            'from_bus_stop_id'    => 23,
            'to_bus_stop_id'      => 1,
            'course'              => json_encode([
                ['latitude' => '13.517537',  'longitude' => '144.807584'],
                ['latitude' => '13.517737',  'longitude' => '144.807578'],
                ['latitude' => '13.518940',  'longitude' => '144.807695'],
                ['latitude' => '13.519785',  'longitude' => '144.807813'],
                ['latitude' => '13.520323',  'longitude' => '144.807834'],
                ['latitude' => '13.520622',  'longitude' => '144.807824'],
                ['latitude' => '13.520880',  'longitude' => '144.807758'],
                ['latitude' => '13.521104',  'longitude' => '144.807674'],
                ['latitude' => '13.521525',  'longitude' => '144.807425'],
                ['latitude' => '13.521794',  'longitude' => '144.807244'],
                ['latitude' => '13.522526',  'longitude' => '144.806664'],
                ['latitude' => '13.522767',  'longitude' => '144.806524'],
                ['latitude' => '13.522996',  'longitude' => '144.806447'],
                ['latitude' => '13.522985',  'longitude' => '144.806414'],
            ]),
        ]);


    }

}
