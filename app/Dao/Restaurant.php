<?php
/**
 * User: yisil2
 * Date: 2017/4/15
 * Time: 2:50
 */

namespace App\Dao;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;

class Restaurant extends Model
{
	protected $guarded = [];

	public static function all($columns = ['*'])
	{
		return DB::select('select * from restaurants');
	}

	public static function find($id)
	{
		$result = DB::select('select * from restaurants where id = :restaurant_id', ['restaurant_id' => $id]);
		if ( count($result) == 0){
			abort(404,"restaurant not found");
		}
		return $result[0];
	}

	public static function search($startDate,$restaurantName)
    {
        if( empty($restaurantName)){
            if(empty($startDate)){
                $result = self::all();
            }else{
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::create($startDate->year,$startDate->month,$startDate->day+1,$startDate->hour,$startDate->minute,$startDate->second,$startDate->tz);
                $result = DB::select('select * from restaurants where start_at >= ? AND start_at < ?',[$startDate,$endDate]);
            }
        }else{
            if(empty($startDate)){
                 $result = DB::select('select * from restaurants where restaurant_name = ?',[$restaurantName]);
            }else{
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::create($startDate->year,$startDate->month,$startDate->day+1,$startDate->hour,$startDate->minute,$startDate->second,$startDate->tz);
                $result = DB::select('select * from restaurants where restaurant_name = ? AND start_at >= ? AND start_at < ?',[$restaurantName,$startDate,$endDate]);
            }
        }
        return $result;
    }
	public static function create(array $attributes = [])
	{
		DB::insert('insert into restaurants (userID, restaurant_name, dish_category, content, location, Email,phone_number, start_at, created_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?)',
			[ 
				$attributes['userID'],
				$attributes['restaurant_name'],
				$attributes['dish_category'],
				$attributes['content'],
				$attributes['location'],
				$attributes['Email'],
				$attributes['phone_number'],
				$attributes['start_at'],
				Carbon::now()
			]);
		$post_id = DB::getPdo()->lastInsertId();
        DB::insert('insert into posts (userID, post_category, post_ID) values (?, ?, ?)',[ $attributes['userID'], 'restaurant', $post_id]);
	}

	public static function destroy($id){
		$result = DB::select('select * from restaurants where id = :id', ['id' => $id]);
		if (count($result) != 0){
			DB::delete('delete from restaurants where id = :id',['id' => $id]);
			DB::delete('delete from posts WHERE post_ID = ? AND post_category = ?',[$id, 'restaurant']);
		}
	}

	public static function edit(array $attributes = []){
		DB::update('update restaurants set restaurant_name = ? , dish_category = ?, content = ?, location = ?, Email = ?, phone_number = ?, start_at = ? WHERE id = ?',
			[
				$attributes['restaurant_name'],
                $attributes['dish_category'],
                $attributes['content'],
                $attributes['location'],
                $attributes['Email'],
                $attributes['phone_number'],
                $attributes['start_at'],
                $attributes['id']
			]);
	}
}