<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Cocoders\BookingLoans\Domain\LoanId;
use Cocoders\BookingLoans\Domain\Money;
use Cocoders\BookingLoans\Domain\LoanBalance;

class DomainContext implements Context
{
    /**
     * @var LoanBalance
     */
    private $loanBalance;

    public function __construct()
    {
    }

    /**
     * @Given że obłsugujemy tylko następującą kolejność rozliczeń:
     */
    public function zeOblsugujemyNastepujacaKolejnoscRozliczen(TableNode $table)
    {
    }

    /**
     * @Given że klient złożył wniosek po pożyczkę na :capitalAmount z prowizją :provisionAmount gdzie wysokość dziennych odsetek wynosi :commisionAmount
     */
    public function zeKlientZlozylWniosekPoPozyczkeNaZlZProwizjaZlGdzieWysokoscDziennychOdsetekWynosiZl(
        Money $capitalAmount,
        Money $provisionAmount,
        Money $commisionAmount
    ) {
        $this->loanBalance = new LoanBalance(
            LoanId::generateNew(),
            $capitalAmount,
            $provisionAmount,
            $commisionAmount
        );
    }

    /**
     * @When klient wpłaci :creditPaymentAmount :day dnia pożyczki
     */
    public function klientWplaciZlDniaPozyczki(Money $creditPaymentAmount, int $day)
    {
        if (!$this->loanBalance) {
            throw new LogicException('Client does not take loan');
        }

        $this->loanBalance->payOff(
            $day,
            $creditPaymentAmount
        );
    }

    /**
     * @Then saldo bilansu pożyczki dla klienta na dzień :day wynosić będzie :balance
     */
    public function saldoBilansuPozyczkiDlaKlientaNaDzienWynosicBedzieZl(int $day, Money $balance)
    {
        if (!$this->loanBalance) {
            throw new LogicException('Client does not take loan');
        }

        $balanceForDay = $this->loanBalance->balanceForDay($day);

        if (!$balance->equals($balanceForDay)) {
            throw new LogicException(
                sprintf(
                    'Loan balance for day %s is not equal %s but %s',
                    $day,
                    $balance,
                    $balanceForDay
                )
            );
        }
    }

    /**
     * @Transform /(.*)zł/
     */
    public function transformToPLN(string $value): Money
    {
        return Money::PLN($value);
    }
}
