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

class Movie extends Model
{
	protected $guarded = [];

	public static function all($columns = ['*'])
	{
		return DB::select('select * from movies');
	}

	public static function find($id)
	{
		$result = DB::select('select * from movies where id = :movie_id', ['movie_id' => $id]);
		if ( count($result) == 0){
			abort(404,"movie not found");
		}
		return $result[0];
	}

	public static function search($startDate,$movieName)
    {
        if( empty($movieName)){
            if(empty($startDate)){
                $result = self::all();
            }else{
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::create($startDate->year,$startDate->month,$startDate->day+1,$startDate->hour,$startDate->minute,$startDate->second,$startDate->tz);
                $result = DB::select('select * from movies where start_at >= ? AND start_at < ?',[$startDate,$endDate]);
            }
        }else{
            if(empty($startDate)){
                 $result = DB::select('select * from movies where movie_name = ?',[$movieName]);
            }else{
                $startDate = Carbon::parse($startDate);
                $endDate = Carbon::create($startDate->year,$startDate->month,$startDate->day+1,$startDate->hour,$startDate->minute,$startDate->second,$startDate->tz);
                $result = DB::select('select * from movies where movie_name = ? AND start_at >= ? AND start_at < ?',[$movieName,$startDate,$endDate]);
            }
        }
        return $result;
    }
	public static function create(array $attributes = [])
	{
		DB::insert('insert into movies (userID, movie_name, movie_category, content, location, Email,phone_number, start_at, created_at) values(?, ?, ?, ?, ?, ?, ?, ?, ?)',
			[ 
				$attributes['userID'],
				$attributes['movie_name'],
				$attributes['movie_category'],
				$attributes['content'],
				$attributes['location'],
				$attributes['Email'],
				$attributes['phone_number'],
				$attributes['start_at'],
				Carbon::now()
			]);
		$post_id = DB::getPdo()->lastInsertId();
        DB::insert('insert into posts (userID, post_category, post_ID) values (?, ?, ?)',[ $attributes['userID'], 'movie', $post_id]);
	}

	public static function destroy($id){
		$result = DB::select('select * from movies where id = :id', ['id' => $id]);
		if (count($result) != 0){
			DB::delete('delete from movies where id = :id',['id' => $id]);
			DB::delete('delete from posts WHERE post_ID = ? AND post_category = ?',[$id, 'movie']);
		}
	}

	public static function edit(array $attributes = []){
		DB::update('update movies set movie_name = ? , movie_category = ?, content = ?, location = ?, Email = ?, phone_number = ?, start_at = ? WHERE id = ?',
			[
				$attributes['movie_name'],
                $attributes['movie_category'],
                $attributes['content'],
                $attributes['location'],
                $attributes['Email'],
                $attributes['phone_number'],
                $attributes['start_at'],
                $attributes['id']
			]);
	}
}