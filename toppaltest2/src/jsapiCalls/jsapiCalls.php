<?php

function getAdminUser()
{
    $json_string = '{
    	"accountInfo": [
    	{
    	"player": {
    			"thumbSrc": "images/movie1.jpg",
            "title": "Best Player Ever!",
            "guid": "14eb98bc-99e4-4c47-922a-36db1737263f"
          }
        },
        {
    	"player": {
    	"thumbSrc": "images/movie2.jpg",
    			"title": "Best Player Ever!",
    			"guid": "14eb98bc-99e4-4c47-922a-36db1737263f"
          }
        }
      ]
    }';
    return $json_string;

}

function getAdminUserList()
{

}