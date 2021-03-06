<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\TimeZoneUtils;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Group extends Model
{
    use HasSlug;

    public static $FOR_TRANSLATE = [
        'adults' => 'Kursai suaugusiems',
        'children' => 'Kursai vaikams',
    ];
    public static $FOR_DATABASE_FIELDS = [
         'Kursai suaugusiems' => 'adults',
         'Kursai vaikams' => 'children',
    ];

    protected $dates = ['time' , 'time_2'];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function group_message(){
        return $this->hasMany(GroupMessage::class);
    }

    public function files(){
        return $this->hasMany(File::class);
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite();

    }

    public function getGroupRewards() {
        $rewards = [];
        $students = $this->students()->get();

        foreach ($students as $student) {
            $user = $student->user()->first();
            if (empty($user)) {
                continue;
            }
            foreach($user->rewards()->get() as $key => $reward) {
                $reward->user_name = $user->name.' '.$user->surname;
                $rewards[$key] = $reward;
            }
        }

        return $rewards;
    }

    public static function getGroupTypeTranslated(string $type): string {
        if ($type === 'yellow') {
            return 'Geltona (2-4m.)';
        }
        if ($type === 'green') {
            return 'Žalia (5-6m.)';
        }
        if ($type === 'blue') {
            return 'Mėlyna (7-9m.)';
        }
        if ($type === 'red') {
            return 'Raudona (10-13m.)';
        }

        if ($type === 'no_type') {
            return 'Kursai suaugusiems';
        }
        if ($type === 'individual') {
            return 'Individualios pamokos';
        }
        return 'Nėra grupės';
    }

    public static function getWeekDay($key) {
            $weekMap = [
                1 => 'Pirmadienis',
                2 => 'Antradienis',
                3 => 'Trečiadienis',
                4 => 'Ketvirtadienis',
                5 => 'Penktadienis',
                6 => 'Šeštadienis',
                0 => 'Sekmadienis',
            ];

            return $weekMap[$key];
    }

    public static function getWeekDayGramCase($key) {
        $weekMap = [
            1 => 'pirmadienį',
            2 => 'antradienį',
            3 => 'trečiadienį',
            4 => 'ketvirtadienį',
            5 => 'penktadienį',
            6 => 'šeštadienį',
            0 => 'sekmadienį',
        ];

        return $weekMap[$key];
    }
    public static function getMonthGenitiveCase($key) {
        $weekMap = [
            1 => 'sausio',
            2 => 'vasario',
            3 => 'kovo',
            4 => 'balandžio',
            5 => 'gegužės',
            6 => 'birželio',
            7 => 'liepos',
            8 => 'rugpjūčio',
            9 => 'rugsėjo',
            10 => 'spalio',
            11 => 'lapkričio',
            12 => 'gruodžio',
        ];

        return $weekMap[$key];
    }

    public function getGroupTypeGenitiveCase() {
        $genetiveCases = [
            'yellow' => 'geltonų',
            'blue' => 'mėlynų',
            'green' => 'žalių',
            'red' => 'raudonų',
            'no_type' => 'suaugusiųjų',
            'bilingualism_consultation' => 'dvikalbystės kursų',
        ];
        return $genetiveCases[$this->type];
    }


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function color(){
        if($this->type == "yellow"){
            return "Geltona";
        }
        if($this->type == "green"){
            return "Žalia";
        }
        if($this->type == "blue"){
            return "Mėlyna";
        }
        if($this->type == "red") {
            return "Raudona";
        }

        if($this->type == "bilingualism_consultation") {
            return "Dvikalbystės";
        }

        if($this->type == "no_type") {
            return "Suaugusiųjų";
        }
    }

    public function lessonsText($lessons){
        if($lessons == 1){
            return "pamoka";
        }else if($lessons >= 2 && $lessons <= 9){
            return "pamokos";
        }
        return "pamokų";
    }

    public function adjustedPrice($coupon = null) {
        $price = $this->price;
        if ($this->type !== 'individual') {
            $price = max(0, $this->price - $this->events()->where("date_at", "<", \Carbon\Carbon::now())->count() * 8);
        }

        if (!empty($coupon) && $coupon->type === 'percent') {
            $price = $price - ($price * $coupon->discount / 100);
        }
        return $price;
    }

    public function hasAdjustedPrice() {
        return $this->adjustedPrice() != $this->price;
    }

    public function getGroupStartDateAndCount() {
        $events = $this->events()->where("date_at", ">", \Carbon\Carbon::now())->get()->toArray();
        if (empty($events)) {
            return [];
        }
        $eventsCount = count($events);
        $startDate = $events[0];
        return ['eventsCount' => $eventsCount,
            'startDate' => $startDate['date_at'],
            'event_update_at' => $startDate['updated_at']
        ];
    }

    public function getAdminTimeAttribute() {
        $today = date("Y-m-d H:i");
        $summerday = TimeZoneUtils::summerTimeStart();
        $winterday = TimeZoneUtils::summerTimeEnd();
        if($today > $summerday && $today < $winterday){
            return $this->time->addHour();
        }
        return $this->time;
    }

    public function getAdminTime2Attribute() {
        $today = date("Y-m-d H:i");
        $summerday = TimeZoneUtils::summerTimeStart();
        $winterday = TimeZoneUtils::summerTimeEnd();
        if($today > $summerday && $today < $winterday){
            return $this->time_2->addHour();
        }
        return $this->time_2;
    }

    public function getAdminTimeModifierAttribute() {
        $today = date("Y-m-d H:i");
        $summerday = TimeZoneUtils::summerTimeStart();
        $winterday = TimeZoneUtils::summerTimeEnd();
        if($today > $summerday && $today < $winterday){
            return "GMT+1";
        }
        return "0 GMT";
    }
}
