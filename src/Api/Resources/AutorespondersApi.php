<?php

namespace OfflineAgency\LaravelEmailChef\Api\Resources;

use Illuminate\Support\Facades\Validator;
use OfflineAgency\LaravelEmailChef\Api\Api;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\Autoresponder;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderActivation;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderCollection;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderCount;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderDeletion;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\AutoresponderLinks;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\Cloning;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\CreateAutoresponder;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\SendTestEmail;
use OfflineAgency\LaravelEmailChef\Entities\Autoresponders\UpdateAutoresponder;
use OfflineAgency\LaravelEmailChef\Entities\Error;

class AutorespondersApi extends Api
{
    public function getCount()
    {
        $response = $this->get('autoresponders/count');

        if (! $response->success) {
            return new Error($response->data);
        }

        $getCount = $response->data;

        return new AutoresponderCount($getCount);
    }

    public function getCollection(
        ?int $limit,
        ?int $offset,
        string $orderby,
        string $ordertype
    ) {
        $response = $this->get('autoresponders', [
            'limit' => $limit,
            'offset' => $offset,
            'orderby' => $orderby,
            'ordertype' => $ordertype,
        ]);

        if (! $response->success) {
            return new Error($response->data);
        }

        $collections = $response->data;
        $out = collect();
        foreach ($collections as $collection) {
            $out->push(new AutoresponderCollection($collection));
        }

        return $out;
    }

    public function getInstance(
        string $id
    ) {
        $response = $this->get('autoresponders/'.$id);

        if (! $response->success) {
            return new Error($response->data);
        }

        $getInstance = $response->data;

        return new Autoresponder($getInstance);
    }

    public function createInstance(
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.id' => 'nullable',
            'instance_in.name' => 'required',
            'instance_in.type' => 'required',
            'instance_in.subject' => 'required',
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
            'instance_in.lists.*.list_id' => 'required',
            'instance_in.lists.*.segment_id' => 'required',
            'instance_in.lists.*.list_name' => 'required',
            'instance_in.lists.*.segment_name' => 'required',
            'instance_in.creativity_type' => 'required',
            'instance_in.template_source' => 'required',
            'instance_in.template_editor_id' => 'required',
            'instance_in.autoresponder.*.id' => 'nullable',
            'instance_in.autoresponder.*.trigger_id' => 'string',
            'instance_in.autoresponder.*.active' => 'string',
            'instance_in.autoresponder.*.hours_delay' => 'int',
            'instance_in.autoresponder.*.campaign_id' => 'nullable',
            'instance_in.autoresponder.*.link_id' => 'nullable',
            'instance_in.default_order_segments' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $response = $this->post('newsletters', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $create = $response->data;

        return new CreateAutoresponder($create);
    }

    public function updateInstance(
        string $id,
        array $body
    ) {
        $validator = Validator::make($body, [
            'instance_in.id' => 'nullable',
            'instance_in.name' => 'required',
            'instance_in.type' => 'required',
            'instance_in.subject' => 'required',
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
            'instance_in.lists.*.list_id' => 'required',
            'instance_in.lists.*.segment_id' => 'required',
            'instance_in.lists.*.list_name' => 'required',
            'instance_in.lists.*.segment_name' => 'required',
            'instance_in.creativity_type' => 'required',
            'instance_in.template_source' => 'required',
            'instance_in.template_editor_id' => 'required',
            'instance_in.autoresponder.*.id' => 'nullable',
            'instance_in.autoresponder.*.trigger_id' => 'string',
            'instance_in.autoresponder.*.active' => 'string',
            'instance_in.autoresponder.*.hours_delay' => 'int',
            'instance_in.autoresponder.*.campaign_id' => 'nullable',
            'instance_in.autoresponder.*.link_id' => 'nullable',
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

        return new UpdateAutoresponder($updateInstance);
    }

    public function deleteInstance(
        string $id
    ) {
        $response = $this->destroy('newsletters/'.$id);
        //dd($response);
        if (! $response->success) {
            return new Error($response->data);
        }

        $deleteInstance = (object) $response->data;

        return new AutoresponderDeletion($deleteInstance);
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

        $response = $this->post('autoresponders/'.$id.'/launcher', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $sendTestEmail = $response->data;

        return new SendTestEmail($sendTestEmail);
    }

    public function activate(
        string $id,
        array $body
    ) {
        $response = $this->put('newsletters/'.$id.'?activate=1', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $activate = $response->data;

        return new AutoresponderActivation($activate);
    }

    public function deactivate(
        string $id,
        array $body
    ) {
        $response = $this->put('newsletters/'.$id.'?activate=-1', $body);

        if (! $response->success) {
            return new Error($response->data);
        }

        $deactivate = $response->data;

        return new AutoresponderActivation($deactivate);
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

    public function getLinksCollection(
        string $id
    ) {
        $response = $this->get('newsletters/'.$id.'/links');

        if (! $response->success) {
            return new Error($response->data);
        }

        $getLinksCollection = (object) $response->data;

        return new AutoresponderLinks($getLinksCollection);
    }
}
