<?php
namespace LaunchDarkly;

/**
 * Contains specific attributes of a user browsing your site.
 *
 * The only mandatory property property is the key, which must uniquely identify each user. For authenticated users,
 * this may be a username or e-mail address. For anonymous users, it could be an IP address or session ID.
 *
 * Use {@link \LaunchDarkly\LDUserBuilder} to construct instances of this class.
 */
class LDUser
{
    protected $_key = null;
    protected $_secondary = null;
    protected $_ip = null;
    protected $_country = null;
    protected $_email = null;
    protected $_name = null;
    protected $_avatar = null;
    protected $_firstName = null;
    protected $_lastName = null;
    protected $_anonymous = false;
    protected $_custom = array();
    protected $_privateAttributeNames = array();

    /**
     * Constructor for directly creating an instance; it is preferable to use LDUserBuilder.
     *
     * @param string $key Unique key for the user. For authenticated users, this may be a username or e-mail address. For anonymous users, this could be an IP address or session ID.
     * @param string|null $secondary An optional secondary identifier
     * @param string|null $ip The user's IP address (optional)
     * @param string|null $country The user's country, as an ISO 3166-1 alpha-2 code (e.g. 'US') (optional)
     * @param string|null $email The user's e-mail address (optional)
     * @param string|null $name The user's full name (optional)
     * @param string|null $avatar A URL pointing to the user's avatar image (optional)
     * @param string|null $firstName The user's first name (optional)
     * @param string|null $lastName The user's last name (optional)
     * @param boolean|null $anonymous Whether this is an anonymous user
     * @param array|null $custom Other custom attributes that can be used to create custom rules
     * @return LDUser
     */
    public function __construct($key, $secondary = null, $ip = null, $country = null, $email = null, $name = null, $avatar = null, $firstName = null, $lastName = null, $anonymous = null, $custom = array(), $privateAttributeNames = array())
    {
        if ($key !== null) {
            $this->_key = strval($key);
        }
        $this->_secondary = $secondary;
        $this->_ip = $ip;
        $this->_country = $country;
        $this->_email = $email;
        $this->_name = $name;
        $this->_avatar = $avatar;
        $this->_firstName = $firstName;
        $this->_lastName = $lastName;
        $this->_anonymous = $anonymous;
        $this->_custom = $custom;
        $this->_privateAttributeNames = $privateAttributeNames;
    }

    /**
     * Used internally in flag evaluation.
     * @ignore
     */
    public function getValueForEvaluation($attr)
    {
        switch ($attr) {
            case "key":
                return $this->getKey();
            case "secondary": //not available for evaluation.
                return null;
            case "ip":
                return $this->getIP();
            case "country":
                return $this->getCountry();
            case "email":
                return $this->getEmail();
            case "name":
                return $this->getName();
            case "avatar":
                return $this->getAvatar();
            case "firstName":
                return $this->getFirstName();
            case "lastName":
                return $this->getLastName();
            case "anonymous":
                return $this->getAnonymous();
            default:
                $custom = $this->getCustom();
                if (is_null($custom)) {
                    return null;
                }
                if (!array_key_exists($attr, $custom)) {
                    return null;
                }
                return $custom[$attr];
        }
    }

    /** @return string|null */
    public function getCountry()
    {
        return $this->_country;
    }

    /** @return array|null */
    public function getCustom()
    {
        return $this->_custom;
    }

    /** @return string|null */
    public function getIP()
    {
        return $this->_ip;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->_key;
    }

    /** @return string|null */
    public function getSecondary()
    {
        return $this->_secondary;
    }

    /** @return string|null */
    public function getEmail()
    {
        return $this->_email;
    }

    /** @return string|null */
    public function getName()
    {
        return $this->_name;
    }

    /** @return string|null */
    public function getAvatar()
    {
        return $this->_avatar;
    }

    /** @return string|null */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /** @return string|null */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /** @return bool|null */
    public function getAnonymous()
    {
        return $this->_anonymous;
    }

    /** @return array|null */
    public function getPrivateAttributeNames()
    {
        return $this->_privateAttributeNames;
    }
    
    /** @return bool */
    public function isKeyBlank()
    {
        return isset($this->_key) && empty($this->_key);
    }
}
