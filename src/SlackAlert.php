<?php

namespace Spatie\SlackAlerts;

class SlackAlert
{
    protected string $webhookUrlName = 'default';
    protected string $channel = '';

    public function to(string $webhookUrlName): self
    {
        $this->webhookUrlName = $webhookUrlName;

        return $this;
    }

    public function channel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function message(string $text): void
    {
        $webhookUrl = Config::getWebhookUrl($this->webhookUrlName);

        if (! $webhookUrl) {
            return;
        }

        $jobArguments = [
            'text' => $text,
            'type' => 'mrkdown',
            'webhookUrl' => $webhookUrl,
        ];

        $job = Config::getJob($jobArguments);

        dispatch($job);
    }
}
