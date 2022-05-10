<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


trait Position{
    protected float $lat;
    protected float $lng;

    public function getAddress(){
        return $this->lat . " - " . $this->lng;
    }

    public function setPosition(float $lat, float $lng){
        if(!is_numeric($lat) && !is_numeric($lng)){
            throw new Exception("I valori inseriti non sono numerici");
        }
        $this->lat = $lat;
        $this->lng = $lng;
    }

}

/**
 * @param Product A new object of Product class
 */
class Product{
    protected $name;
    protected $category;
    protected $price;
    protected $kindOfAnimal;
    
    
    function __construct($name, $category, $price, $kindOfAnimal){
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->kindOfAnimal = $kindOfAnimal;
    }

    
    function getName(){
        return $this->name;
    }

    function getPrice(){
        return $this->price;
    }
}


/**
 * @param Food A new object of Food class
 */
class Food extends Product{
    protected $name;
    protected $weight;
    protected $expireDate;
    
    
    function __construct($weight, $expireDate, $name, $category, $price, $kindOfAnimal){
        parent::__construct($name, $category, $price, $kindOfAnimal);
        $this->weight = $weight;
        $this->expireDate = $expireDate;
    }

    function getWeight(){
        return $this->weight;
    }

    function getExpireDate(){
        return "Il prodotto scade il " . $this->expireDate;
    }
}

/**
 * @param CreditCard A new object of CreditCard class
 */
class CreditCard{
    protected $number;
    protected $expireYear;
    protected $cvv;
    protected $bank;
    protected $balance;
    protected $isValid;

    function __construct($number, $expireYear, $cvv, $bank, $balance, $isValid = false){
        $this->number = $number;

        if($expireYear > 2022){
            $this->expireYear = $expireYear;
        }

        $this->cvv = $cvv;
        $this->bank = $bank;
        $this->balance = $balance;

        if(is_numeric($number) && strlen($number) == 16 && strlen($cvv) == 3 && $expireYear > 2022){
            $this->isValid = true;
        } else {
            $this->isValid = false;
        }
    }

    function getBalance(){
        return $this->balance . "€";
    }

    function getValidation(){
        return $this->isValid;
    }
}


/**
 * @param User A new object of User class
 */
class User{
    Use Position;

    protected string $firstName;
    protected string $lastName;
    protected int $birthYear;
    protected string $email;
    protected string $username;
    protected bool $isRegistred;
    protected CreditCard $creditCard;
    protected int $discount;
    protected array $cart;


    
    /**
     * @param string $firstName User's first name
     * @param string $lastName User's last name
     * @param int $birtYear User's year of birth
     * @param string $email User's email
     * @param string $username User's nickname
     * @param bool $isRegistred Bool to check if user is logged
     * @param CreditCard $creditCard User's credit card
     * @param int $discount User's percentage of discount
     * @param array $cart User's cart of products
     *  
     * */
    function __construct($firstName, $lastName, $birthYear, $email, $username, $isRegistred = false, $creditCard, $discount = null, $cart = []){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthYear = $birthYear;
        $this->email = $email;
        $this->username = $username;
        $this->isRegistred = $isRegistred;
        $this->creditCard = $creditCard;
        $this->cart = [];

        if($isRegistred){
            $this->discount = 20;
        } else {
            $this->discount = 0;
        }
    }

    function getName(){
        return $this->firstName . " " . $this->lastName;
    }

    function getBirthYear(){
        return "L'anno di nascita è il " .  $this->birthYear;
    }

    function getEmail(){
        return "L'indirizzo email è " . $this->email;
    }


    function buyProduct($product){
        $price = $product->getPrice();
        if($this->creditCard->getValidation() && $price <= $this->creditCard->getBalance()){
            if($this->isRegistred){
                return "Hai acquistato il prodotto e hai speso: €" . $price/100*80;
            } else {
                return "Hai acquistato il prodotto e hai speso: €" . $price;
            }
        }
    }
}


Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', function () {
    $card = new CreditCard("1234567890123456", 2025, 123, "Deutsche Bank", 500);
    $utente = new User("Luca", "Rossi", 1998, "luca.rossi@gmail.com", "l.rossi2022", true, $card, null, []);
    $croccantini = new Food("5kg", "2025/04/02", "croccantini", "Food", 9.99, "gatto");
    return view('layouts.main', ["utente" => $utente], ["croccantini" => $croccantini]);
})->name('main');
