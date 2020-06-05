<?php


namespace App\Data;

// use App\Data\SearchData;

class SearchData 
{
     /**
     * @var string
     */
    public $q = '';

    /**
     * @var Categorie[]
     */
    public $categorie = [];

     /**
     * @var Marque[]
     */
    public $marque = [];

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;

    /**
     * @var boolean
     */
    public $promo = false;

}
