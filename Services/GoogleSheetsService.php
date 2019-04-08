<?php

namespace HappyR\Google\ApiBundle\Services;

use REverse\GSheets\Client as GoogleSheetsClient;
use REverse\GSheets\SpreadSheets;

class GoogleSheetsService
{
    /**
     * @var GoogleSheetsClient
     */
    private $googleSheetsClient;

    /**
     * @var Spreadsheets
     */
    private $spreadsheets;

    /**
     * GoogleSheetsService constructor.
     * @param GoogleClient $googleClient
     */
    public function __construct(GoogleClient $googleClient)
    {
        $this->googleSheetsClient = new GoogleSheetsClient($googleClient->getGoogleClient());
    }

    public function setSpreadsheets($spreadsheetsId)
    {
        if (empty($spreadsheetsId)) {
            throw new \InvalidArgumentException(sprintf('$spreadsheetsId must not be empty'));
        }

        $this->spreadsheets = new SpreadSheets($this->googleSheetsClient, $spreadsheetsId);
    }

    public function hasSpreadsheet()
    {
        return $this->spreadsheets !== null;
    }

    public function updateRow($value, $sheet, $row, $optParams = [])
    {
        $this->spreadsheets->updateRow($value, $sheet, $row, $optParams);
    }


    public function clearRow($sheet, $row)
    {
        $this->spreadsheets->clearRow($sheet, $row);
    }

    public function update($value, $range, $optParams = [])
    {
        $this->spreadsheets->update($value, $range, $optParams);
    }

    public function append($value, $range, $optParams = [])
    {
        $this->spreadsheets->append($value, $range, $optParams);
    }

    public function clear($range)
    {
        $this->spreadsheets->clear($range);
    }

    public function get($range)
    {
        return $this->spreadsheets->get($range);
    }

    public function delete($dimension, $sheet, $startIndex, $endIndex)
    {
        $this->spreadsheets->delete($dimension, $sheet, $startIndex, $endIndex);
    }

    /**
     * @return GoogleSheetsClient
     */
    public function getGoogleSheetsClient()
    {
        return $this->googleSheetsClient;
    }

    /**
     * @return Spreadsheets
     */
    public function getSpreadsheets()
    {
        return $this->spreadsheets;
    }
}
