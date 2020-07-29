<?php


namespace App\Service;


use App\Repository\RefundRepository;
use \DateTime;

class PeriodBoardMaker
{

    private $refundRepository;
    const CASH = 'CASH';

    public function __construct(RefundRepository $refundRepository)
    {
        $this->refundRepository = $refundRepository;
    }

    public function makeArrayForPeriodBoard(array $data): array
    {
        $result = [];

        foreach ($data as $datum) {

            $refund = (null !== $this->refundRepository->getTotalRefundByDate(new Datetime($datum['date'])))
                ? $this->refundRepository->getTotalRefundByDate(new Datetime($datum['date']))
                : 0
            ;
            $result[$datum['date']][$datum['payment_mode']] = [
                'total'        => (!isset($result[$datum['date']][$datum['payment_mode']]['total']))
                    ? $datum['total'] : $result[$datum['date']][$datum['payment_mode']]['total'] + $datum['total']
                    ,
            ];
            if (null !== $datum['identifier'] && $datum['identifier'] === self::CASH) {
                $result[$datum['date']][$datum['payment_mode']]['refund'] = $refund;
            } else {
                $result[$datum['date']][$datum['payment_mode']]['refund'] = 0;
            }
        }
        return $result;
    }

}
