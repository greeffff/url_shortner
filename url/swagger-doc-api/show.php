<?php

namespace PetstoreIO;

/**
 * @SWG\swager(type="object", @SWG\Xml(name="Show"))
 */
class Show
{

    /**
     * @SWG\Property(format="int64")
     * @var string
     */
    public $id;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    public $url;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    public $code;

    /**
     * @var \DateTime
     * @SWG\Property()
     */
    public $created_ad;

    /**
     * @var \DateTime
     * @SWG\Property()
     */
    public $updated_id;

    /**
     * @SWG\Property(format="int64")
     * @var string
     */
    public $hits;
}
