<?php

namespace App\Helpers;

use App\Models\Country, App\Models\State, App\Models\City, 
	App\Models\Sub_City, App\Models\Categorie, App\Models\Job;

class Location{

	public function locations(){

		$country_lon_lat = Country::get(array("id","longitude","latitude"))->toArray();
		//echo "<pre>";print_r($country_lon_lat);exit;
		$lon_lat = array();
		foreach ($country_lon_lat as $key => $value) {
			$lon_lat['longitude']['country'][$value['id']] = $value['longitude'];
			$lon_lat['latitude']['country'][$value['id']] = $value['latitude'];
		}
		
		$country = Country::getCountries();
		$sub_city = Sub_City::getSubCities();
		$state = State::get(array("id","name","country_id","longitude","latitude"))->toArray();
		$states = array();
		foreach ($state as $key => $value) {
			$states[$value['country_id']][$value['id']] = $value['name'];
			$lon_lat['longitude']['state'][$value['id']] = $value['longitude'];
			$lon_lat['latitude']['state'][$value['id']] = $value['latitude']; 
		}

		$cities = array();
		$city = City::get(array("id","name","state_id","longitude","latitude"))->toArray();
		$cities = array();
		foreach ($city as $key => $value) {
			$cities[$value['state_id']][$value['id']] = $value['name'];
			$lon_lat['longitude']['city'][$value['id']] = $value['longitude'];
			$lon_lat['latitude']['city'][$value['id']] = $value['latitude'];  
		}
		$sub_cities = array();
		$sub_city = Sub_City::get(array("id","name","city_id","longitude","latitude"))->toArray();
		$sub_cities = array();
		foreach ($sub_city as $key => $value) {
			$sub_cities[$value['city_id']][$value['id']] = $value['name'];
			$lon_lat['longitude']['sub_city'][$value['id']] = $value['longitude'];
			$lon_lat['latitude']['sub_city'][$value['id']] = $value['latitude']; 
		}
		//echo "<pre>";print_r($lon_lat);exit;

		return[$lon_lat, $country, $states, $cities, $sub_cities];
	}

}
