<?php 
//单例工厂类： 通过这个工厂得到对象，并且保证单例
class ModelFactory{
	static $all_model = array();
	static function M($model_name){
		if(!array_key_exists($model_name, static::$all_model) || !(static::$all_model[$model_name] instanceof $model_name)){
			static::$all_model[$model_name] = new $model_name();
		}
		return static::$all_model[$model_name];
	}
}
 ?>