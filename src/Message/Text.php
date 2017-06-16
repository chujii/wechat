<?php
/**
 * @Author: binghe
 * @Date:   2017-06-16 16:43:50
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-16 16:44:00
 */
namespace Binghe\Wechat\Message;

/**
 * Class Text.
 *
 * @property string $content
 */
class Text extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'text';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = ['content'];
}
