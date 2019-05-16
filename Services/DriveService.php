<?php

namespace HappyR\Google\ApiBundle\Services;

use Psr\Http\Message\ResponseInterface;

/**
 * Class DriveService
 *
 * This is the class that communicates with Drive api
 */
class DriveService extends \Google_Service_Drive
{
    /**
     * @var GoogleClient client
     */
    public $client;

    /**
     * Constructor
     * @param GoogleClient $client
     */
    public function __construct(GoogleClient $client)
    {
        $this->client = $client;
        parent::__construct($client->getGoogleClient());
    }

    /**
     * @param $fileId
     * @param $name
     * @return \Google_Service_Drive_DriveFile
     */
    public function copy($fileId, $name)
    {
        return $this->files->copy(
            $fileId,
            new \Google_Service_Drive_DriveFile(['name' => $name])
        );
    }

    /**
     * @param $fileId
     * @param $permission
     * @return \Google_Service_Drive_Permission
     */
    public function addPermission($fileId, $permission)
    {
        return $this->permissions->create(
            $fileId,
            new \Google_Service_Drive_Permission($permission),
            array('fields' => 'id')
        );
    }

    /**
     * @param $fileId
     * @param $permissionId
     * @return ResponseInterface
     */
    public function deletePermission($fileId, $permissionId)
    {
        return $this->permissions->delete($fileId, $permissionId);
    }

    /**
     * @param $presentationId
     * @return \Google_Service_Drive_PermissionList
     */
    public function listPermissions($presentationId)
    {
        return $this->permissions->listPermissions($presentationId);
    }

    /**
     * @param $type
     * @param $role
     * @param $value
     * @return array
     */
    public function preparePermission($type, $role, $value = null)
    {
        $permissions = ['type' => $type, 'role' => $role];

        switch ($type) {
            case 'domain':
                $permissions['domain'] = $value;
                break;
            case 'user':
                $permissions['emailAddress'] = $value;
                break;
            case 'group':
                // @todo
                break;
            case 'anyone':
            default:
                break;
        }

        return $permissions;
    }
}
