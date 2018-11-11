<?php

namespace Bytesoft\SeoHelper\Entities\Twitter;

use Bytesoft\SeoHelper\Contracts\Entities\TwitterCardContract;
use Bytesoft\SeoHelper\Exceptions\InvalidTwitterCardException;

class Card implements TwitterCardContract
{

    /**
     * Card type.
     *
     * @var string
     */
    protected $type;

    /**
     * Card meta collection.
     *
     * @var \Bytesoft\SeoHelper\Contracts\Entities\MetaCollectionContract
     */
    protected $meta;

    /**
     * Card images.
     *
     * @var array
     */
    protected $images = [];

    /**
     * Make the twitter card instance.
     * @author ARCANEDEV
     */
    public function __construct()
    {
        $this->meta = new MetaCollection;
    }

    /**
     * Set the card type.
     *
     * @param  string $type
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     * @throws InvalidTwitterCardException
     */
    public function setType($type)
    {
        if (empty($type)) {
            return $this;
        }

        $this->checkType($type);
        $this->type = $type;

        return $this->addMeta('card', $type);
    }

    /**
     * Set card site.
     *
     * @param  string $site
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     */
    public function setSite($site)
    {
        if (empty($site)) {
            return $this;
        }

        $this->checkSite($site);

        return $this->addMeta('site', $site);
    }

    /**
     * Set card title.
     *
     * @param  string $title
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     */
    public function setTitle($title)
    {
        return $this->addMeta('title', $title);
    }

    /**
     * Set card description.
     *
     * @param  string $description
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     */
    public function setDescription($description)
    {
        return $this->addMeta('description', $description);
    }

    /**
     * Add image to the card.
     *
     * @param  string $url
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     */
    public function addImage($url)
    {
        if (count($this->images) < 4) {
            $this->images[] = $url;
        }

        return $this;
    }

    /**
     * Add many meta to the card.
     *
     * @param  array $meta
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     */
    public function addMetas(array $meta)
    {
        $this->meta->addMany($meta);

        return $this;
    }

    /**
     * Add a meta to the card.
     *
     * @param  string $name
     * @param  string $content
     *
     * @return \Bytesoft\SeoHelper\Entities\Twitter\Card
     * @author ARCANEDEV
     */
    public function addMeta($name, $content)
    {
        $this->meta->add($name, $content);

        return $this;
    }

    /**
     * Get all supported card types.
     *
     * @return array
     * @author ARCANEDEV
     */
    public function types()
    {
        return [
            static::TYPE_APP,
            static::TYPE_GALLERY,
            static::TYPE_PHOTO,
            static::TYPE_PLAYER,
            static::TYPE_PRODUCT,
            static::TYPE_SUMMARY,
            static::TYPE_SUMMARY_LARGE_IMAGE,
        ];
    }

    /**
     * Render card images.
     * @author ARCANEDEV
     */
    protected function loadImages()
    {
        if (count($this->images) == 1) {
            $this->addMeta('image', $this->images[0]);

            return;
        }

        foreach ($this->images as $number => $url) {
            $this->addMeta('image{' . $number . '}', $url);
        }
    }

    /**
     * Reset the card.
     *
     * @return Card
     * @author ARCANEDEV
     */
    public function reset()
    {
        $this->meta->reset();
        $this->images = [];

        return $this;
    }

    /**
     * Render the twitter card.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function render()
    {
        if (!empty($this->images)) {
            $this->loadImages();
        }

        return $this->meta->render();
    }

    /**
     * Render the tag.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Check the card type.
     *
     * @param  string $type
     *
     * @throws \Bytesoft\SeoHelper\Exceptions\InvalidTwitterCardException
     * @author ARCANEDEV
     */
    protected function checkType(&$type)
    {
        if (!is_string($type)) {
            throw new InvalidTwitterCardException(
                'The Twitter card type must be a string value, [' . gettype($type) . '] was given.'
            );
        }

        $type = strtolower(trim($type));

        if (!in_array($type, $this->types())) {
            throw new InvalidTwitterCardException('The Twitter card type [' . $type . '] is not supported.');
        }
    }

    /**
     * Check the card site.
     *
     * @param  string $site
     * @author ARCANEDEV
     */
    protected function checkSite(&$site)
    {
        $site = $this->prepareUsername($site);
    }

    /**
     * Prepare username.
     *
     * @param  string $username
     *
     * @return string
     * @author ARCANEDEV
     */
    protected function prepareUsername($username)
    {
        if (!starts_with($username, '@')) {
            $username = '@' . $username;
        }

        return $username;
    }
}
