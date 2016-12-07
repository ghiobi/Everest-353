<?php
namespace App\Library;

/**
 * Class PostalCoder
 * @package App\Library
 */
class PostalCoder
{
    /**
     * Search engine
     * @var \Illuminate\Foundation\Application|mixed
     */
    private $engine;

    /**
     * Address place
     *
     * @var null
     */
    private $place = null;

    /**
     * PostalCoder constructor. Instantiates the Geocoder Instance see
     * Providers\GeocoderServiceProvider.php
     */
    public function __construct()
    {
        $this->engine = app('geocoder');
    }

    /**
     * Returns this if it's a valid postal code.
     *
     * @param $postalCode
     * @return $this|null
     */
    public function geocode($postalCode)
    {
        if (!preg_match('/(^[a-z]\d[a-z]\s?\d[a-z]\d$)/i', $postalCode) && !preg_match('/(^[a-z]\d[a-z]$)/i', $postalCode)){
            return null;
        }

        $postalCode = strtoupper($postalCode);

        //Properly formats postal code.
        if (strlen($postalCode) == 6){
            $postalCode = substr($postalCode, 0, 3) . ' ' . substr($postalCode, 3, 3);
        }

        try{
            //Find post code, if successful returns true
            $this->place = $this->engine->using('google_maps')->geocode($postalCode)
                ->first();

            return $this;

        } catch (\Geocoder\Exception\UnsupportedOperation $e){ }

        return null;
    }

    /**
     *
     * Returns a properly formatted Postal Code
     *
     * @return bool
     */
    public function getPostalCode()
    {
        if ($this->place != null) {
            return $this->place->getPostalCode();
        }
        return null;
    }

    /**
     * Returns the city.
     *
     * @return bool
     */
    public function getCity()
    {
        if ($this->place != null){
            return $this->place->getLocality();
        }
        return null;
    }

    /**
     * Returns the province
     *
     * @return bool
     */
    public function getProvince()
    {
        if ($this->place != null){
            return $this->place->getAdminLevels()->first()->getName();
        }
        return null;
    }

    /**
     * Returns longitude
     *
     * @return bool
     */
    public function getLongitude()
    {
        if ($this->place != null){
            return $this->place->getLongitude();
        }
        return null;
    }

    /**
     * Returns latitude
     *
     * @return bool
     */
    public function getLatitude()
    {
        if ($this->place != null){
            return $this->place->getLatitude();
        }
        return null;
    }

    /**
     *
     */
    public function toArray()
    {
        return [
            'postal_code' => $this->getPostalCode(),
            'city' => $this->getCity(),
            'province' => $this->getProvince(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude()
        ];
    }

}