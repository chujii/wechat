<?php
/**
 * @Author: binghe
 * @Date:   2017-06-12 11:55:44
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-12 11:56:20
 */
namespace Binghe\Wechat\Message;

/**
 * Class Article.
 */
class Article extends AbstractMessage
{
    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
                                'thumb_media_id',
                                'author',
                                'title',
                                'content',
                                'digest',
                                'source_url',
                                'show_cover',
                            ];

    /**
     * Aliases of attribute.
     *
     * @var array
     */
    protected $aliases = [
        'source_url' => 'content_source_url',
        'show_cover' => 'show_cover_pic',
    ];
}