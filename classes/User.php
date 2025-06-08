<?php
require_once __DIR__ . '/UniversalDB.php';
require_once __DIR__ . '/../_functions/debug_to_console.php';

class User
{
    private $id;
    private $email;
    private $password;

    public function __construct($id = null, $email = null, $password = null)
    {
        session_start();
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;

        if (!isset($_SESSION['user_id'])) $_SESSION['user_id'] = $this->id;
        if (!isset($_SESSION['email'])) $_SESSION['email'] = $this->email;
        if (!isset($_SESSION['password'])) $_SESSION['password'] = $this->password;

        debug_to_console("constructed" . " id: " . $_SESSION['user_id'] . " email: " . $_SESSION['email'] . " hash password: " . $_SESSION['password']);
        debug_to_console("Wishlist cookie: " . (isset($_COOKIE['wishlist']) ? $_COOKIE['wishlist'] : "empty"));

    }

    public function login($email, $password)
    {
        if (!empty($email) && !empty($password)) {
            $clientDB = new UniversalDB('clients');
            $userData = $clientDB->getEmail($email);

            if (!empty($userData) && password_verify($password, $userData[0]['password'])) {
                $this->id = $userData[0]['id'];
                $this->email = $userData[0]['email'];
                $this->password = $userData[0]['password'];
                $_SESSION['user_id'] = $this->id;
                $_SESSION['email'] = $this->email;
                $_SESSION['password'] = $this->password;

                debug_to_console("Login Success - ID: " . $this->id . " Email: " . $this->email . " Password: " . $this->password);
            } else {
                debug_to_console("Login failed for email: " . $email);
            }


        }
    }

    public function  register($name, $email, $password, $description) {
        $clientDB = new UniversalDB('clients');
        $clientDB->create($name, $email, $password, $description);;
        
        $this->login($email, $password);;
    }

    public function logout()
    {
        session_destroy();
        debug_to_console("Logout Success");
    }

    public function wishlistRemove($ID)
    {
        $wishlist = array();
        if (isset($_COOKIE['wishlist'])) {
            $decoded = json_decode($_COOKIE['wishlist'], true);
            if (is_array($decoded)) {
                $wishlist = $decoded;
                if (isset($wishlist[$_SESSION['email']])) {
                    $key = array_search($ID, array_reverse($wishlist[$_SESSION['email']], true));
                    if ($key !== false) {
                        unset($wishlist[$_SESSION['email']][$key]);
                        $wishlist[$_SESSION['email']] = array_values($wishlist[$_SESSION['email']]);
                        setcookie('wishlist', json_encode($wishlist), time() + (86400 * 30), '/');
                    }
                }
            }
        }
    }

    public function wishlistAdd($ID)
    {

        $wishlist = array();
        if (isset($_COOKIE['wishlist'])) {
            $decoded = json_decode($_COOKIE['wishlist'], true);
            if (is_array($decoded)) {
                $wishlist = $decoded;
            }
        }

        if (!isset($wishlist[$_SESSION['email']])) {
            $wishlist[$_SESSION['email']] = array();
        }
        $wishlist[$_SESSION['email']][] = $ID;


        $encoded = json_encode($wishlist);
        setcookie('wishlist', $encoded, time() + (86400 * 30), "/");
    }


    public function wishlistClear()
    {
        if (isset($_COOKIE['wishlist'])) {
            $wishlist = json_decode($_COOKIE['wishlist'], true);
            if (isset($_SESSION['email'])) {
                if (isset($wishlist[$_SESSION['email']])) {
                    unset($wishlist[$_SESSION['email']]);
                }
            } else {
                if (isset($wishlist[""])) {
                    unset($wishlist[""]);
                }
            }
            setcookie('wishlist', json_encode($wishlist), time() + (86400 * 30), '/');
        }
    }

    public function getWishlistPrice()
    {
        $price = 0;
        if (isset($_COOKIE['wishlist'])) {
            $decoded = json_decode($_COOKIE['wishlist'], true);
            if (is_array($decoded)) {
                $wishlist = $decoded;
                if (isset($wishlist[$_SESSION['email']])) {
                    foreach ($wishlist[$_SESSION['email']] as $item) {
                        $productDB = new UniversalDB('products');
                        $product = $productDB->readID($item);
                        if (isset($product[0]['price'])) {
                            $price += $product[0]['price'];
                        }
                    }
                }
            }
        }
        return $price;
    }

    public function getWishlistCount()
    {
        $count = 0;
        if (isset($_COOKIE['wishlist'])) {
            $decoded = json_decode($_COOKIE['wishlist'], true);
            if (is_array($decoded)) {
                $wishlist = $decoded;
                if (isset($wishlist[$_SESSION['email']])) {
                    $count = count($wishlist[$_SESSION['email']]);
                }
            }
        }
        return $count;
    }
    public function getEmail()
    {
        return $this->email;
    }


}