<?php

class CountryService
{
    private $phoneCountryMap = [
        '+7'   => 'Russia',
        '+1'   => 'USA',    
        '+44'  => 'United Kingdom',
        '+49'  => 'Germany',
        '+33'  => 'France',
        '+39'  => 'Italy',
        '+34'  => 'Spain',
        '+81'  => 'Japan',
        '+86'  => 'China',
        '+61'  => 'Australia',
        '+64'  => 'New Zealand',
        '+41'  => 'Switzerland',
        '+46'  => 'Sweden',
        '+47'  => 'Norway',
        '+45'  => 'Denmark',
        '+358' => 'Finland',
        '+353' => 'Ireland',
        '+32'  => 'Belgium',
        '+31'  => 'Netherlands',
        '+30'  => 'Greece',
        '+36'  => 'Hungary',
        '+48'  => 'Poland',
        '+420' => 'Czech Republic',
        '+421' => 'Slovakia',
        '+420' => 'Slovakia',
        '+43'  => 'Austria',
        '+359' => 'Bulgaria',
        '+372' => 'Estonia',
        '+371' => 'Latvia',
        '+370' => 'Lithuania',
        '+375' => 'Belarus',
        '+380' => 'Ukraine',
        '+373' => 'Moldova',
        '+381' => 'Serbia',
        '+382' => 'Montenegro',
        '+385' => 'Croatia',
        '+387' => 'Bosnia and Herzegovina',
        '+386' => 'Slovenia',
        '+389' => 'North Macedonia',        
        '+998' => 'Uzbekistan',
        '+996' => 'Kyrgyzstan',
        '+995' => 'Georgia',
        '+974' => 'Qatar',
        '+971' => 'United Arab Emirates',
        '+966' => 'Saudi Arabia',
        '+965' => 'Kuwait',
        '+968' => 'Oman',
        '+967' => 'Yemen',
        '+62'  => 'Indonesia',
        '+63'  => 'Philippines',
        '+66'  => 'Thailand',
        '+84'  => 'Vietnam',
        '+60'  => 'Malaysia',
        '+65'  => 'Singapore',
        '+62'  => 'Indonesia',
        '+673' => 'Brunei',
        '+855' => 'Cambodia',
        '+86'  => 'China',
        '+853' => 'Macau',
        '+852' => 'Hong Kong',
        '+92'  => 'Pakistan',
        '+91'  => 'India',
        '+94'  => 'Sri Lanka',
        '+60'  => 'Malaysia',
        '+63'  => 'Philippines',
        '+62'  => 'Indonesia',
        '+66'  => 'Thailand',
        '+84'  => 'Vietnam',
    ];

    public function getCountryByPhone(string $phone): string
    {
        foreach ($this->phoneCountryMap as $prefix => $country) {
            if (strpos($phone, $prefix) === 0) {
                return $country;
            }
        }

        return 'Unknown'; // Значение по умолчанию, если страна не определена
    }
}

?>