<?php

namespace Yosmy\Payment\Card;

use Yosmy\Payment;
use Yosmy;

/**
 * @di\service({
 *     tags: [
 *         'yosmy.payment.card.post_defer_ownership_fail',
 *     ]
 * })
 */
class AnalyzePostDeferOwnershipFailToLogEvent implements AnalyzePostDeferOwnershipFail
{
    /**
     * @var Yosmy\LogEvent
     */
    private $logEvent;

    /**
     * @param Yosmy\LogEvent     $logEvent
     */
    public function __construct(
        Yosmy\LogEvent $logEvent
    ) {
        $this->logEvent = $logEvent;
    }

    /**
     * {@inheritDoc}
     */
    public function analyze(
        Payment\Card $card,
        int $amount,
        NotDeferrableOwnershipException $e
    ) {
        $this->logEvent->log(
            [
                'yosmy.payment.card.defer_ownership_fail',
                'fail'
            ],
            [
                'user' => $card->getUser(),
                'card' => $card->getId()
            ],
            [
                'amount' => $amount,
                'reason' => $e->getReason()
            ]
        );
    }
}