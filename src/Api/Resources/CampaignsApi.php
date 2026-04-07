<?php

declare(strict_types=1);

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

final class CampaignsApi extends Api
{
    public function getCount(): mixed {
        $response = $this->get('campaigns/count');

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $getCount = $response->data;

        return CampaignCount::fromResponse($getCount);
    }

    public function getCollection(
        string $status,
        ?int $limit,
        ?int $offset,
        string $orderby,
        string $ordertype,
    ): mixed {
        $response = $this->get('campaigns', [
            'status'    => $status,
            'limit'     => $limit,
            'offset'    => $offset,
            'orderby'   => $orderby,
            'ordertype' => $ordertype,
        ]);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $collections = $response->data;
        $out = collect();

        foreach ($collections as $collection) {
            $out->push(CampaignCollection::fromResponse($collection));
        }

        return $out;
    }

    public function getInstance(
        string $id,
    ): mixed {
        $response = $this->get('campaigns/'.$id);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $getInstance = $response->data;

        return Campaign::fromResponse($getInstance);
    }

    /**
     * @param array<string, mixed> $body
     */
    public function createInstance(
        array $body,
    ): mixed {
        $validator = Validator::make($body, [
            'instance_in.id'                                => 'nullable',
            'instance_in.name'                              => 'required',
            'instance_in.type'                              => 'required',
            'instance_in.subject'                           => 'nullable',
            'instance_in.new_dd'                            => 'required',
            'instance_in.html_body'                         => 'required',
            'instance_in.sender_id'                         => 'required',
            'instance_in.template_id'                       => 'nullable',
            'instance_in.sent_count_cache'                  => 'required',
            'instance_in.open_count_cache'                  => 'required',
            'instance_in.click_count_cache'                 => 'required',
            'instance_in.cache_update_time'                 => 'nullable',
            'instance_in.ga_enabled'                        => 'required',
            'instance_in.ga_campaign_title'                 => 'string',
            'instance_in.lists'                             => 'array',
            'instance_in.creativity_type'                   => 'required',
            'instance_in.template_source'                   => 'required',
            'instance_in.template_editor_id'                => 'required',
            'instance_in.pre_header'                        => 'string',
            'instance_in.campaign.*.id'                     => 'nullable',
            'instance_in.campaign.*.recipients_count_cache' => 'string',
            'instance_in.campaign.*.status'                 => 'string',
            'instance_in.campaign.*.scheduled_time'         => 'nullable',
            'instance_in.default_order_segments'            => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('newsletters', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $createInstance = (object) $response->data;

        return CreateCampaign::fromResponse($createInstance);
    }

    /**
     * @param array<string, mixed> $body
     */
    public function updateInstance(
        string $id,
        array $body,
    ): mixed {
        $validator = Validator::make($body, [
            'instance_in.id'                                => 'nullable',
            'instance_in.name'                              => 'required',
            'instance_in.type'                              => 'required',
            'instance_in.subject'                           => 'nullable',
            'instance_in.new_dd'                            => 'required',
            'instance_in.html_body'                         => 'required',
            'instance_in.sender_id'                         => 'required',
            'instance_in.template_id'                       => 'nullable',
            'instance_in.sent_count_cache'                  => 'required',
            'instance_in.open_count_cache'                  => 'required',
            'instance_in.click_count_cache'                 => 'required',
            'instance_in.cache_update_time'                 => 'nullable',
            'instance_in.ga_enabled'                        => 'required',
            'instance_in.ga_campaign_title'                 => 'string',
            'instance_in.lists'                             => 'array',
            'instance_in.creativity_type'                   => 'required',
            'instance_in.template_source'                   => 'required',
            'instance_in.template_editor_id'                => 'required',
            'instance_in.pre_header'                        => 'string',
            'instance_in.campaign.*.id'                     => 'nullable',
            'instance_in.campaign.*.recipients_count_cache' => 'string',
            'instance_in.campaign.*.status'                 => 'string',
            'instance_in.campaign.*.scheduled_time'         => 'nullable',
            'instance_in.default_order_segments'            => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->put('newsletters/'.$id, $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $updateInstance = $response->data;

        return UpdateCampaign::fromResponse($updateInstance);
    }

    public function deleteInstance(
        string $id,
    ): mixed {
        $response = $this->destroy('campaigns/'.$id);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $deleteInstance = (object) $response->data;

        return CampaignDeletion::fromResponse($deleteInstance);
    }

    /**
     * @param array<string, mixed> $body
     */
    public function sendTestEmail(
        string $id,
        array $body,
    ): mixed {
        $validator = Validator::make($body, [
            'instance_in.id'      => 'required',
            'instance_in.command' => 'required',
            'instance_in.email'   => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('campaigns/'.$id.'/launcher', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $sendTestEmail = $response->data;

        return SendTestEmail::fromResponse($sendTestEmail);
    }

    /**
     * @param array<string, mixed> $body
     */
    public function sendCampaign(
        string $id,
        array $body,
    ): mixed {
        $response = $this->post('campaigns/'.$id.'/launcher', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $sendCampaign = $response->data;

        return SendCampaign::fromResponse($sendCampaign);
    }

    /**
     * @param array<string, mixed> $body
     */
    public function schedule(
        string $id,
        array $body,
    ): mixed {
        $response = $this->post('campaigns/'.$id.'/launcher', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $schedule = $response->data;

        return Schedule::fromResponse($schedule);
    }

    public function cancelScheduling(
        string $id,
    ): mixed {
        $response = $this->put('campaigns/'.$id.'/cancelscheduling', []);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $cancelScheduling = $response->data;

        return CancelScheduling::fromResponse($cancelScheduling);
    }

    public function archive(
        string $id,
    ): mixed {
        $response = $this->put('campaigns/'.$id.'/archivecampaign', []);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $archive = $response->data;

        return CampaignArchiving::fromResponse($archive);
    }

    public function unarchive(
        string $campaign_id,
    ): mixed {
        $response = $this->put('campaigns/'.$campaign_id.'/unarchivecampaign', []);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $unarchive = $response->data;

        return CampaignArchiving::fromResponse($unarchive);
    }

    /**
     * @param array<string, mixed> $body
     */
    public function cloning(
        array $body,
    ): mixed {
        $validator = Validator::make($body, [
            'instance_in.id' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('newsletters?clone=1', $body);

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $clone = $response->data;

        return Cloning::fromResponse($clone);
    }

    public function getLinkCollection(
        string $id,
    ): mixed {
        $response = $this->get('newsletters/'.$id.'/links');

        if (! $response->success) {
            return Error::fromResponse($response->data);
        }

        $getLinkCollection = (object) $response->data;

        return LinkCollection::fromResponse($getLinkCollection);
    }
}
