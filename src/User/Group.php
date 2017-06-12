<?php
/**
 * @Author: binghe
 * @Date:   2017-06-12 13:19:32
 * @Last Modified by:   binghe
 * @Last Modified time: 2017-06-12 13:20:24
 */
namespace Binghe\Wechat\User;

use Binghe\Wechat\Core\AbstractAPI;

/**
 * Class Group.
 */
class Group extends AbstractAPI
{
    const API_GET = 'https://api.weixin.qq.com/cgi-bin/groups/get';
    const API_CREATE = 'https://api.weixin.qq.com/cgi-bin/groups/create';
    const API_UPDATE = 'https://api.weixin.qq.com/cgi-bin/groups/update';
    const API_DELETE = 'https://api.weixin.qq.com/cgi-bin/groups/delete';
    const API_USER_GROUP_ID = 'https://api.weixin.qq.com/cgi-bin/groups/getid';
    const API_MEMBER_UPDATE = 'https://api.weixin.qq.com/cgi-bin/groups/members/update';
    const API_MEMBER_BATCH_UPDATE = 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate';

    /**
     * Create group.
     *
     * @param string $name
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function create($name)
    {
        $params = [
                   'group' => ['name' => $name],
                  ];

        return $this->parseJSON('json', [self::API_CREATE, $params]);
    }

    /**
     * List all groups.
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function lists()
    {
        return $this->parseJSON('get', [self::API_GET]);
    }

    /**
     * Update a group name.
     *
     * @param int    $groupId
     * @param string $name
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function update($groupId, $name)
    {
        $params = [
                   'group' => [
                               'id' => $groupId,
                               'name' => $name,
                              ],
                  ];

        return $this->parseJSON('json', [self::API_UPDATE, $params]);
    }

    /**
     * Delete group.
     *
     * @param int $groupId
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function delete($groupId)
    {
        $params = [
                   'group' => ['id' => $groupId],
                  ];

        return $this->parseJSON('json', [self::API_DELETE, $params]);
    }

    /**
     * Get user group.
     *
     * @param string $openId
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function userGroup($openId)
    {
        $params = ['openid' => $openId];

        return $this->parseJSON('json', [self::API_USER_GROUP_ID, $params]);
    }

    /**
     * Move user to a group.
     *
     * @param string $openId
     * @param int    $groupId
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function moveUser($openId, $groupId)
    {
        $params = [
                   'openid' => $openId,
                   'to_groupid' => $groupId,
                  ];

        return $this->parseJSON('json', [self::API_MEMBER_UPDATE, $params]);
    }

    /**
     * Batch move users to a group.
     *
     * @param array $openIds
     * @param int   $groupId
     *
     * @return \Binghe\Wechat\Support\Collection
     */
    public function moveUsers(array $openIds, $groupId)
    {
        $params = [
                   'openid_list' => $openIds,
                   'to_groupid' => $groupId,
                  ];

        return $this->parseJSON('json', [self::API_MEMBER_BATCH_UPDATE, $params]);
    }
}