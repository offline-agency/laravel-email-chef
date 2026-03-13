<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\Campaign;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignArchiving;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignCollection;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignCount;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CampaignDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CancelScheduling;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\Cloning;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\CreateCampaign;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\LinkCollection;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\Schedule;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\SendCampaign;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\SendTestEmail;
use OfflineAgency\LaravelEmailChef\Entities\Campaigns\UpdateCampaign;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class CampaignsApi extends Api
{
    public function getCount()
    {
        $response = $this->get('campaigns/count');

        if (! $response->success) {
            return new Error($response->data);
        }

        $getCount = $response->data;

        return new CampaignCount($getCount);
    }

    public function getCollection(
        string $status,
        ?int $limit,
        ?int $offset,
        string $orderby,
        string $ordertype
    ) {
        $response = $this->get('campaigns', [
            'status' => $status,
            'limit' => $limit,
            'offset' => $offset,
            'orderby' => $orderby,
            'ordertype' => $ordertype,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $collections = (object) $response->data;
        $out = collect();
        foreach ($collections as $collection) {
            $out->push(new CampaignCollection($collection));
        }

        return $out;
    }

    public function getInstance(
        string $id
    ) {
        $response = $this->get('campaigns/'.$id);

        if (! $response->success) {
            return new Error($response->data);
        }

        $getInstance = $response->data;

        return new Campaign($getInstance);
    }

    public function createInstance(
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.id' => 'nullable',
            'instance_in.name' => 'required',
            'instance_in.type' => 'required',
            'instance_in.subject' => 'nullable',
            'instance_in.new_dd' => 'required',
            'instance_in.html_body' => 'required',
            'instance_in.sender_id' => 'required',
            'instance_in.template_id' => 'nullable',
            'instance_in.sent_count_cache' => 'required',
            'instance_in.open_count_cache' => 'required',
            'instance_in.click_count_cache' => 'required',
            'instance_in.cache_update_time' => 'nullable',
            'instance_in.ga_enabled' => 'required',
            'instance_in.ga_campaign_title' => 'string',
            'instance_in.lists' => 'array',
            'instance_in.creativity_type' => 'required',
            'instance_in.template_source' => 'required',
            'instance_in.template_editor_id' => 'required',
            'instance_in.pre_header' => 'string',
            'instance_in.campaign.*.id' => 'nullable',
            'instance_in.campaign.*.recipients_count_cache' => 'string',
            'instance_in.campaign.*.status' => 'string',
            'instance_in.campaign.*.scheduled_time' => 'nullable',
            'instance_in.default_order_segments' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('newsletters', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $createInstance = (object) $response->data;

        return new CreateCampaign($createInstance);
    }

    public function updateInstance(
        string $id,
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.id' => 'nullable',
            'instance_in.name' => 'required',
            'instance_in.type' => 'required',
            'instance_in.subject' => 'nullable',
            'instance_in.new_dd' => 'required',
            'instance_in.html_body' => 'required',
            'instance_in.sender_id' => 'required',
            'instance_in.template_id' => 'nullable',
            'instance_in.sent_count_cache' => 'required',
            'instance_in.open_count_cache' => 'required',
            'instance_in.click_count_cache' => 'required',
            'instance_in.cache_update_time' => 'nullable',
            'instance_in.ga_enabled' => 'required',
            'instance_in.ga_campaign_title' => 'string',
            'instance_in.lists' => 'array',
            'instance_in.creativity_type' => 'required',
            'instance_in.template_source' => 'required',
            'instance_in.template_editor_id' => 'required',
            'instance_in.pre_header' => 'string',
            'instance_in.campaign.*.id' => 'nullable',
            'instance_in.campaign.*.recipients_count_cache' => 'string',
            'instance_in.campaign.*.status' => 'string',
            'instance_in.campaign.*.scheduled_time' => 'nullable',
            'instance_in.default_order_segments' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put('newsletters/'.$id, $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $updateInstance = $response->data;

        return new UpdateCampaign($updateInstance);
    }

    public function deleteInstance(
        string $id
    ) {
        $response = $this->destroy('campaigns/'.$id);

        if (! $response->success) {
            return new Error($response->data);
        }

        $deleteInstance = (object) $response->data;

        return new CampaignDeletion($deleteInstance);
    }

    public function sendTestEmail(
        string $id,
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.id' => 'required',
            'instance_in.command' => 'required',
            'instance_in.email' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('campaigns/'.$id.'/launcher', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $sendTestEmail = $response->data;

        return new SendTestEmail($sendTestEmail);
    }

    public function sendCampaign(
        string $id,
        array $body
    ) {
        $response = $this->post('campaigns/'.$id.'/launcher', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $sendCampaign = $response->data;

        return new SendCampaign($sendCampaign);
    }

    public function schedule(
        string $id,
        array $body
    ) {
        $response = $this->post('campaigns/'.$id.'/launcher', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $schedule = $response->data;

        return new Schedule($schedule);
    }

    public function cancelScheduling(
        string $id
    ) {
        $response = $this->put('campaigns/'.$id.'/cancelscheduling', []);

        if (! $response->success) {
            return new Error($response->data);
        }

        $cancelScheduling = $response->data;

        return new CancelScheduling($cancelScheduling);
    }

    public function archive(
        string $id
    ) {
        $response = $this->put('campaigns/'.$id.'/archivecampaign', []);

        if (! $response->success) {
            return new Error($response->data);
        }

        $archive = $response->data;

        return new CampaignArchiving($archive);
    }

    public function unarchive(
        string $campaign_id
    ) {
        $response = $this->put('campaigns/'.$campaign_id.'/unarchivecampaign', []);

        if (! $response->success) {
            return new Error($response->data);
        }

        $unarchive = $response->data;

        return new CampaignArchiving($unarchive);
    }

    public function cloning(
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.id' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('newsletters?clone=1', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $clone = $response->data;

        return new Cloning($clone);
    }

    public function getLinkCollection(
        string $id
    ) {
        $response = $this->get('newsletters/'.$id.'/links');

        if (! $response->success) {
            return new Error($response->data);
        }

        $getLinkCollection = (object) $response->data;

        return new LinkCollection($getLinkCollection);
    }
}
