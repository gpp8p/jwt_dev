<?php

use Illuminate\Database\Seeder;
use App\Layout;
use App\Group;


class Layouts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $layoutName = "Root Layout";
        $layoutHeight = 10;
        $layoutWidth = 10;
        $layoutDescription = "Initial layout";
        $layoutBackgroundColor = "#f5f4e4";
        $layoutInstance = new Layout;
        $thisUserId = DB::table('users')->where('name', 'spaces_admin')->first()->id;
        $rootOrgId =  DB::table('org')->where('org_label', 'root')->first()->id;
        $newLayoutId = $layoutInstance->createLayoutWithoutBlanks($layoutName, $layoutHeight, $layoutWidth, $layoutDescription, $layoutBackgroundColor, $backgroundImage, $backgroundType);

        $thisGroup = new Group;
        $personalGroupId = $thisGroup->returnPersonalGroupId($thisUserId);
        $newLayoutGroupId = $thisGroup->addNewLayoutGroup($newLayoutId, $layoutName, $layoutDescription);
        $thisGroup->addOrgToGroup($rootOrgId, $newLayoutGroupId);
        $layoutInstance->editPermForGroup($newLayoutGroupId, $newLayoutId, 'view', 1);
        $userPersonalGroupId = $personalGroupId;
        $layoutInstance->editPermForGroup($userPersonalGroupId, $newLayoutId, 'view', 1);
        $layoutInstance->editPermForGroup($userPersonalGroupId, $newLayoutId, 'author', 1);
        $layoutInstance->editPermForGroup($userPersonalGroupId, $newLayoutId, 'admin', 1);

    }
}
