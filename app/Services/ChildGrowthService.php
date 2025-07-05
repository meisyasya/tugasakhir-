<?php

namespace App\Services;

class ChildGrowthService
{
    /**
     * Data standar WHO Height-for-age for GIRLS (0 to 5 years / 0-60 months).
     * Struktur: [usia_bulan => ['3rd' => val, '15th' => val, 'median' => val, '85th' => val, '97th' => val]]
     * Disarankan untuk memindahkan ini ke database atau file konfigurasi terpisah.
     */
    private array $whoHeightForAgeGirls = [
        // Data dari "Length-for-age GIRLS Birth to 2 years (percentiles)" (0-23 bulan)
        0 => ['3rd' => 45.6, '15th' => 47.2, 'median' => 49.1, '85th' => 51.1, '97th' => 52.7],
        1 => ['3rd' => 50.0, '15th' => 51.7, 'median' => 53.7, '85th' => 55.7, '97th' => 57.4],
        2 => ['3rd' => 53.2, '15th' => 55.0, 'median' => 57.1, '85th' => 59.2, '97th' => 60.9],
        3 => ['3rd' => 55.8, '15th' => 57.6, 'median' => 59.8, '85th' => 62.0, '97th' => 63.8],
        4 => ['3rd' => 58.0, '15th' => 59.8, 'median' => 62.1, '85th' => 64.3, '97th' => 66.2],
        5 => ['3rd' => 59.9, '15th' => 61.7, 'median' => 64.0, '85th' => 66.3, '97th' => 68.2],
        6 => ['3rd' => 61.5, '15th' => 63.4, 'median' => 65.7, '85th' => 68.1, '97th' => 70.0],
        7 => ['3rd' => 62.9, '15th' => 64.9, 'median' => 67.3, '85th' => 69.7, '97th' => 71.6],
        8 => ['3rd' => 64.3, '15th' => 66.3, 'median' => 68.7, '85th' => 71.2, '97th' => 73.2],
        9 => ['3rd' => 65.6, '15th' => 67.6, 'median' => 70.1, '85th' => 72.6, '97th' => 74.7],
        10 => ['3rd' => 66.8, '15th' => 68.9, 'median' => 71.5, '85th' => 74.0, '97th' => 76.1],
        11 => ['3rd' => 68.0, '15th' => 70.2, 'median' => 72.8, '85th' => 75.4, '97th' => 77.5],
        12 => ['3rd' => 69.2, '15th' => 71.3, 'median' => 74.0, '85th' => 76.7, '97th' => 78.9],
        13 => ['3rd' => 70.3, '15th' => 72.5, 'median' => 75.2, '85th' => 77.9, '97th' => 80.2],
        14 => ['3rd' => 71.3, '15th' => 73.6, 'median' => 76.4, '85th' => 79.2, '97th' => 81.4],
        15 => ['3rd' => 72.4, '15th' => 74.7, 'median' => 77.5, '85th' => 80.3, '97th' => 82.7],
        16 => ['3rd' => 73.3, '15th' => 75.7, 'median' => 78.6, '85th' => 81.5, '97th' => 83.9],
        17 => ['3rd' => 74.3, '15th' => 76.7, 'median' => 79.7, '85th' => 82.6, '97th' => 85.0],
        18 => ['3rd' => 75.2, '15th' => 77.7, 'median' => 80.7, '85th' => 83.7, '97th' => 86.2],
        19 => ['3rd' => 76.2, '15th' => 78.7, 'median' => 81.7, '85th' => 84.8, '97th' => 87.3],
        20 => ['3rd' => 77.0, '15th' => 79.6, 'median' => 82.7, '85th' => 85.8, '97th' => 88.4],
        21 => ['3rd' => 77.9, '15th' => 80.5, 'median' => 83.7, '85th' => 86.8, '97th' => 89.4],
        22 => ['3rd' => 78.7, '15th' => 81.4, 'median' => 84.6, '85th' => 87.8, '97th' => 90.5],
        23 => ['3rd' => 79.6, '15th' => 82.2, 'median' => 85.5, '85th' => 88.8, '97th' => 91.5],
        // Data dari "Height-for-age GIRLS 2 to 5 years (percentiles)" (24-60 bulan)
        24 => ['3rd' => 79.6, '15th' => 82.4, 'median' => 85.1, '85th' => 88.1, '97th' => 91.8],
        25 => ['3rd' => 80.4, '15th' => 83.2, 'median' => 86.0, '85th' => 89.0, '97th' => 92.8],
        26 => ['3rd' => 81.2, '15th' => 84.0, 'median' => 86.8, '85th' => 89.9, '97th' => 93.7],
        27 => ['3rd' => 82.0, '15th' => 84.7, 'median' => 87.5, '85th' => 90.7, '97th' => 94.6],
        28 => ['3rd' => 82.7, '15th' => 85.5, 'median' => 88.3, '85th' => 91.5, '97th' => 95.5],
        29 => ['3rd' => 83.4, '15th' => 86.3, 'median' => 89.0, '85th' => 92.3, '97th' => 96.4],
        30 => ['3rd' => 84.0, '15th' => 87.0, 'median' => 89.7, '85th' => 93.0, '97th' => 97.3],
        31 => ['3rd' => 84.7, '15th' => 87.7, 'median' => 90.4, '85th' => 93.7, '97th' => 98.2],
        32 => ['3rd' => 85.4, '15th' => 88.4, 'median' => 91.1, '85th' => 94.4, '97th' => 99.0],
        33 => ['3rd' => 86.0, '15th' => 89.1, 'median' => 91.8, '85th' => 95.1, '97th' => 99.9],
        34 => ['3rd' => 86.7, '15th' => 89.8, 'median' => 92.5, '85th' => 95.7, '97th' => 100.6],
        35 => ['3rd' => 87.3, '15th' => 90.5, 'median' => 93.1, '85th' => 96.4, '97th' => 101.4],
        36 => ['3rd' => 87.9, '15th' => 91.1, 'median' => 93.7, '85th' => 97.0, '97th' => 102.2],
        37 => ['3rd' => 88.5, '15th' => 91.7, 'median' => 94.4, '85th' => 97.6, '97th' => 103.0],
        38 => ['3rd' => 89.1, '15th' => 92.4, 'median' => 95.0, '85th' => 98.2, '97th' => 103.7],
        39 => ['3rd' => 89.7, '15th' => 93.0, 'median' => 95.6, '85th' => 98.8, '97th' => 104.5],
        40 => ['3rd' => 90.3, '15th' => 93.6, 'median' => 96.2, '85th' => 99.4, '97th' => 105.2],
        41 => ['3rd' => 90.8, '15th' => 94.2, 'median' => 96.8, '85th' => 100.0, '97th' => 106.0],
        42 => ['3rd' => 91.4, '15th' => 94.8, 'median' => 97.4, '85th' => 100.5, '97th' => 106.7],
        43 => ['3rd' => 92.0, '15th' => 95.4, 'median' => 97.9, '85th' => 101.1, '97th' => 107.4],
        44 => ['3rd' => 92.5, '15th' => 95.9, 'median' => 98.5, '85th' => 101.7, '97th' => 108.1],
        45 => ['3rd' => 93.1, '15th' => 96.5, 'median' => 99.0, '85th' => 102.2, '97th' => 108.8],
        46 => ['3rd' => 93.6, '15th' => 97.0, 'median' => 99.5, '85th' => 102.8, '97th' => 109.5],
        47 => ['3rd' => 94.1, '15th' => 97.6, 'median' => 100.1, '85th' => 103.3, '97th' => 110.2],
        48 => ['3rd' => 94.6, '15th' => 98.1, 'median' => 100.6, '85th' => 103.8, '97th' => 110.8],
        49 => ['3rd' => 95.1, '15th' => 98.6, 'median' => 101.1, '85th' => 104.4, '97th' => 111.5],
        50 => ['3rd' => 95.7, '15th' => 99.1, 'median' => 101.6, '85th' => 104.9, '97th' => 112.1],
        51 => ['3rd' => 96.2, '15th' => 99.6, 'median' => 102.1, '85th' => 105.4, '97th' => 112.8],
        52 => ['3rd' => 96.7, '15th' => 100.1, 'median' => 102.6, '85th' => 105.9, '97th' => 113.4],
        53 => ['3rd' => 97.2, '15th' => 100.6, 'median' => 103.1, '85th' => 106.4, '97th' => 114.1],
        54 => ['3rd' => 97.6, '15th' => 101.0, 'median' => 103.5, '85th' => 106.8, '97th' => 114.7],
        55 => ['3rd' => 98.1, '15th' => 101.5, 'median' => 104.0, '85th' => 107.3, '97th' => 115.3],
        56 => ['3rd' => 98.6, '15th' => 102.0, 'median' => 104.5, '85th' => 107.8, '97th' => 116.0],
        57 => ['3rd' => 99.1, '15th' => 102.4, 'median' => 104.9, '85th' => 108.2, '97th' => 116.6],
        58 => ['3rd' => 99.6, '15th' => 102.9, 'median' => 105.4, '85th' => 108.7, '97th' => 117.2],
        59 => ['3rd' => 100.0, '15th' => 103.4, 'median' => 105.9, '85th' => 109.2, '97th' => 117.8],
        60 => ['3rd' => 100.4, '15th' => 103.8, 'median' => 106.3, '85th' => 109.6, '97th' => 118.4],
    ];

    /**
     * Data standar WHO Height-for-age for BOYS (0 to 5 years / 0-60 months).
     * Anda juga perlu mengisi data ini dengan data WHO asli dan lengkap untuk anak laki-laki.
     */



 private array $whoHeightForAgeBoys = [
    // Data for Year: 0, Months: 0-11 (Length-for-age, from first image)
    0 => ['3rd' => 46.3, '15th' => 47.9, 'median' => 49.9, '85th' => 51.8, '97th' => 53.4],
    1 => ['3rd' => 51.1, '15th' => 52.7, 'median' => 54.7, '85th' => 56.7, '97th' => 58.4],
    2 => ['3rd' => 54.7, '15th' => 56.4, 'median' => 58.4, '85th' => 60.5, '97th' => 62.2],
    3 => ['3rd' => 57.6, '15th' => 59.3, 'median' => 61.4, '85th' => 63.5, '97th' => 65.3],
    4 => ['3rd' => 60.0, '15th' => 61.7, 'median' => 63.9, '85th' => 66.0, '97th' => 67.8],
    5 => ['3rd' => 61.9, '15th' => 63.7, 'median' => 65.9, '85th' => 68.1, '97th' => 69.9],
    6 => ['3rd' => 63.6, '15th' => 65.4, 'median' => 67.6, '85th' => 69.8, '97th' => 71.6],
    7 => ['3rd' => 65.1, '15th' => 66.9, 'median' => 69.2, '85th' => 71.4, '97th' => 73.2],
    8 => ['3rd' => 66.5, '15th' => 68.3, 'median' => 70.6, '85th' => 72.9, '97th' => 74.7],
    9 => ['3rd' => 67.7, '15th' => 69.6, 'median' => 72.0, '85th' => 74.3, '97th' => 76.2],
    10 => ['3rd' => 69.0, '15th' => 70.9, 'median' => 73.3, '85th' => 75.6, '97th' => 77.6],
    11 => ['3rd' => 70.2, '15th' => 72.1, 'median' => 74.5, '85th' => 77.0, '97th' => 78.9],

    // Data for Year: 1, Months: 0-11 (i.e., 12-23 months) (Length-for-age, from first image)
    12 => ['3rd' => 71.3, '15th' => 73.3, 'median' => 75.7, '85th' => 78.2, '97th' => 80.2],
    13 => ['3rd' => 72.4, '15th' => 74.4, 'median' => 76.9, '85th' => 79.4, '97th' => 81.5],
    14 => ['3rd' => 73.4, '15th' => 75.5, 'median' => 78.0, '85th' => 80.6, '97th' => 82.7],
    15 => ['3rd' => 74.4, '15th' => 76.5, 'median' => 79.1, '85th' => 81.8, '97th' => 83.9],
    16 => ['3rd' => 75.4, '15th' => 77.5, 'median' => 80.2, '85th' => 82.9, '97th' => 85.1],
    17 => ['3rd' => 76.3, '15th' => 78.5, 'median' => 81.2, '85th' => 84.0, '97th' => 86.2],
    18 => ['3rd' => 77.2, '15th' => 79.5, 'median' => 82.3, '85th' => 85.1, '97th' => 87.3],
    19 => ['3rd' => 78.1, '15th' => 80.4, 'median' => 83.2, '85th' => 86.1, '97th' => 88.4],
    20 => ['3rd' => 78.9, '15th' => 81.3, 'median' => 84.2, '85th' => 87.1, '97th' => 89.5],
    21 => ['3rd' => 79.7, '15th' => 82.2, 'median' => 85.1, '85th' => 88.1, '97th' => 90.5],
    22 => ['3rd' => 80.5, '15th' => 83.0, 'median' => 86.0, '85th' => 89.1, '97th' => 91.6],
    23 => ['3rd' => 81.3, '15th' => 83.8, 'median' => 86.9, '85th' => 90.0, '97th' => 92.6],

    // Data for Year: 2, Months: 0-11 (i.e., 24-35 months) (Height-for-age, from second image)
    24 => ['3rd' => 81.4, '15th' => 83.9, 'median' => 87.1, '85th' => 90.3, '97th' => 92.9],
    25 => ['3rd' => 82.1, '15th' => 84.7, 'median' => 88.0, '85th' => 91.2, '97th' => 93.8],
    26 => ['3rd' => 82.8, '15th' => 85.5, 'median' => 88.8, '85th' => 92.1, '97th' => 94.8],
    27 => ['3rd' => 83.5, '15th' => 86.3, 'median' => 89.6, '85th' => 93.0, '97th' => 95.7],
    28 => ['3rd' => 84.2, '15th' => 87.0, 'median' => 90.4, '85th' => 93.8, '97th' => 96.6],
    29 => ['3rd' => 84.9, '15th' => 87.7, 'median' => 91.2, '85th' => 94.7, '97th' => 97.5],
    30 => ['3rd' => 85.5, '15th' => 88.4, 'median' => 91.9, '85th' => 95.5, '97th' => 98.3],
    31 => ['3rd' => 86.2, '15th' => 89.1, 'median' => 92.7, '85th' => 96.2, '97th' => 99.2],
    32 => ['3rd' => 86.8, '15th' => 89.7, 'median' => 93.4, '85th' => 97.0, '97th' => 100.0],
    33 => ['3rd' => 87.4, '15th' => 90.4, 'median' => 94.1, '85th' => 97.8, '97th' => 100.8],
    34 => ['3rd' => 88.0, '15th' => 91.0, 'median' => 94.8, '85th' => 98.5, '97th' => 101.5],
    35 => ['3rd' => 88.5, '15th' => 91.6, 'median' => 95.4, '85th' => 99.2, '97th' => 102.3],

    // Data for Year: 3, Months: 0-11 (i.e., 36-47 months) (Height-for-age, from second image)
    36 => ['3rd' => 89.1, '15th' => 92.2, 'median' => 96.1, '85th' => 99.9, '97th' => 103.1],
    37 => ['3rd' => 89.7, '15th' => 92.8, 'median' => 96.7, '85th' => 100.6, '97th' => 103.8],
    38 => ['3rd' => 90.2, '15th' => 93.4, 'median' => 97.4, '85th' => 101.3, '97th' => 104.5],
    39 => ['3rd' => 90.8, '15th' => 94.0, 'median' => 98.0, '85th' => 102.0, '97th' => 105.2],
    40 => ['3rd' => 91.3, '15th' => 94.6, 'median' => 98.6, '85th' => 102.7, '97th' => 105.9],
    41 => ['3rd' => 91.9, '15th' => 95.2, 'median' => 99.2, '85th' => 103.3, '97th' => 106.6],
    42 => ['3rd' => 92.4, '15th' => 95.7, 'median' => 99.9, '85th' => 104.0, '97th' => 107.3],
    43 => ['3rd' => 92.9, '15th' => 96.3, 'median' => 100.4, '85th' => 104.6, '97th' => 108.0],
    44 => ['3rd' => 93.4, '15th' => 96.8, 'median' => 101.0, '85th' => 105.2, '97th' => 108.6],
    45 => ['3rd' => 93.9, '15th' => 97.4, 'median' => 101.6, '85th' => 105.8, '97th' => 109.3],
    46 => ['3rd' => 94.4, '15th' => 97.9, 'median' => 102.2, '85th' => 106.5, '97th' => 109.9],
    47 => ['3rd' => 94.9, '15th' => 98.5, 'median' => 102.8, '85th' => 107.1, '97th' => 110.6],

    // Data for Year: 4, Months: 0-11 (i.e., 48-59 months) (Height-for-age, from second image)
    48 => ['3rd' => 95.4, '15th' => 99.0, 'median' => 103.3, '85th' => 107.7, '97th' => 111.2],
    49 => ['3rd' => 95.9, '15th' => 99.5, 'median' => 103.9, '85th' => 108.3, '97th' => 111.8],
    50 => ['3rd' => 96.4, '15th' => 100.0, 'median' => 104.4, '85th' => 108.9, '97th' => 112.5],
    51 => ['3rd' => 96.9, '15th' => 100.5, 'median' => 105.0, '85th' => 109.5, '97th' => 113.1],
    52 => ['3rd' => 97.4, '15th' => 101.1, 'median' => 105.6, '85th' => 110.1, '97th' => 113.7],
    53 => ['3rd' => 97.9, '15th' => 101.6, 'median' => 106.1, '85th' => 110.7, '97th' => 114.3],
    54 => ['3rd' => 98.4, '15th' => 102.1, 'median' => 106.7, '85th' => 111.2, '97th' => 115.0],
    55 => ['3rd' => 98.8, '15th' => 102.6, 'median' => 107.2, '85th' => 111.8, '97th' => 115.6],
    56 => ['3rd' => 99.3, '15th' => 103.1, 'median' => 107.8, '85th' => 112.4, '97th' => 116.2],
    57 => ['3rd' => 99.8, '15th' => 103.6, 'median' => 108.3, '85th' => 113.0, '97th' => 116.8],
    58 => ['3rd' => 100.3, '15th' => 104.1, 'median' => 108.9, '85th' => 113.6, '97th' => 117.4],
    59 => ['3rd' => 100.8, '15th' => 104.7, 'median' => 109.4, '85th' => 114.2, '97th' => 118.1],

    // Data for Year: 5, Month: 0 (i.e., 60 months) (Height-for-age, from second image)
    60 => ['3rd' => 101.2, '15th' => 105.2, 'median' => 110.0, '85th' => 114.8, '97th' => 118.7],
];

    // Data berat badan kosong karena Anda meminta untuk menghapusnya.
    // Jika suatu saat ingin mengembalikannya, Anda perlu method loadDummyWeightForAgeBoysData/GirlsData
    // dan mengisi properti ini dengan data asli.
    private array $whoWeightForAgeGirls = [
        0 => ['3rd' => 2.4, '15th' => 2.8, 'median' => 3.2, '85th' => 3.7, '97th' => 4.2],
        1 => ['3rd' => 3.2, '15th' => 3.6, 'median' => 4.0, '85th' => 4.7, '97th' => 5.4],
        2 => ['3rd' => 4.0, '15th' => 4.5, 'median' => 5.1, '85th' => 5.9, '97th' => 6.5],
        3 => ['3rd' => 4.6, '15th' => 5.1, 'median' => 5.8, '85th' => 6.7, '97th' => 7.4],
        4 => ['3rd' => 5.1, '15th' => 5.6, 'median' => 6.4, '85th' => 7.3, '97th' => 8.1],
        5 => ['3rd' => 5.5, '15th' => 6.1, 'median' => 6.9, '85th' => 7.8, '97th' => 8.7],
        6 => ['3rd' => 5.8, '15th' => 6.4, 'median' => 7.3, '85th' => 8.3, '97th' => 9.2],
        7 => ['3rd' => 6.1, '15th' => 6.7, 'median' => 7.6, '85th' => 8.7, '97th' => 9.6],
        8 => ['3rd' => 6.3, '15th' => 7.0, 'median' => 7.9, '85th' => 9.0, '97th' => 10.0],
        9 => ['3rd' => 6.6, '15th' => 7.3, 'median' => 8.2, '85th' => 9.3, '97th' => 10.4],
        10 => ['3rd' => 6.8, '15th' => 7.5, 'median' => 8.5, '85th' => 9.6, '97th' => 10.7],
        11 => ['3rd' => 7.0, '15th' => 7.7, 'median' => 8.7, '85th' => 9.9, '97th' => 11.0],
        12 => ['3rd' => 7.1, '15th' => 7.9, 'median' => 8.9, '85th' => 10.2, '97th' => 11.3],
        13 => ['3rd' => 7.3, '15th' => 8.1, 'median' => 9.2, '85th' => 10.4, '97th' => 11.6],
        14 => ['3rd' => 7.5, '15th' => 8.3, 'median' => 9.4, '85th' => 10.7, '97th' => 11.9],
        15 => ['3rd' => 7.7, '15th' => 8.5, 'median' => 9.6, '85th' => 10.9, '97th' => 12.2],
        16 => ['3rd' => 7.8, '15th' => 8.7, 'median' => 9.8, '85th' => 11.2, '97th' => 12.5],
        17 => ['3rd' => 8.0, '15th' => 8.8, 'median' => 10.0, '85th' => 11.4, '97th' => 12.7],
        18 => ['3rd' => 8.2, '15th' => 9.0, 'median' => 10.2, '85th' => 11.6, '97th' => 13.0],
        19 => ['3rd' => 8.3, '15th' => 9.2, 'median' => 10.4, '85th' => 11.9, '97th' => 13.3],
        20 => ['3rd' => 8.5, '15th' => 9.4, 'median' => 10.6, '85th' => 12.1, '97th' => 13.5],
        21 => ['3rd' => 8.7, '15th' => 9.6, 'median' => 10.9, '85th' => 12.4, '97th' => 13.8],
        22 => ['3rd' => 8.8, '15th' => 9.8, 'median' => 11.1, '85th' => 12.6, '97th' => 14.1],
        23 => ['3rd' => 9.0, '15th' => 9.9, 'median' => 11.3, '85th' => 12.8, '97th' => 14.3],
        24 => ['3rd' => 9.1, '15th' => 10.1, 'median' => 11.5, '85th' => 13.1, '97th' => 14.6],
        25 => ['3rd' => 9.3, '15th' => 10.3, 'median' => 11.7, '85th' => 13.3, '97th' => 14.9],
        26 => ['3rd' => 9.5, '15th' => 10.5, 'median' => 11.9, '85th' => 13.6, '97th' => 15.2],
        27 => ['3rd' => 9.6, '15th' => 10.7, 'median' => 12.1, '85th' => 13.8, '97th' => 15.4],
        28 => ['3rd' => 9.8, '15th' => 10.8, 'median' => 12.3, '85th' => 14.0, '97th' => 15.7],
        29 => ['3rd' => 10.0, '15th' => 11.0, 'median' => 12.5, '85th' => 14.3, '97th' => 16.0],
        30 => ['3rd' => 10.1, '15th' => 11.2, 'median' => 12.7, '85th' => 14.5, '97th' => 16.2],
        31 => ['3rd' => 10.3, '15th' => 11.3, 'median' => 12.9, '85th' => 14.7, '97th' => 16.5],
        32 => ['3rd' => 10.4, '15th' => 11.5, 'median' => 13.1, '85th' => 14.9, '97th' => 16.8],
        33 => ['3rd' => 10.5, '15th' => 11.7, 'median' => 13.3, '85th' => 15.2, '97th' => 17.0],
        34 => ['3rd' => 10.7, '15th' => 11.8, 'median' => 13.5, '85th' => 15.4, '97th' => 17.3],
        35 => ['3rd' => 10.8, '15th' => 12.0, 'median' => 13.7, '85th' => 15.7, '97th' => 17.6],
        36 => ['3rd' => 11.0, '15th' => 12.1, 'median' => 13.9, '85th' => 15.9, '97th' => 17.8],
        37 => ['3rd' => 11.1, '15th' => 12.3, 'median' => 14.0, '85th' => 16.1, '97th' => 18.1],
        38 => ['3rd' => 11.2, '15th' => 12.5, 'median' => 14.2, '85th' => 16.3, '97th' => 18.4],
        39 => ['3rd' => 11.4, '15th' => 12.6, 'median' => 14.4, '85th' => 16.6, '97th' => 18.6],
        40 => ['3rd' => 11.5, '15th' => 12.8, 'median' => 14.6, '85th' => 16.8, '97th' => 18.9],
        41 => ['3rd' => 11.6, '15th' => 12.9, 'median' => 14.8, '85th' => 17.0, '97th' => 19.2],
        42 => ['3rd' => 11.8, '15th' => 13.1, 'median' => 15.0, '85th' => 17.3, '97th' => 19.5],
        43 => ['3rd' => 11.9, '15th' => 13.2, 'median' => 15.2, '85th' => 17.5, '97th' => 19.7],
        44 => ['3rd' => 12.0, '15th' => 13.4, 'median' => 15.3, '85th' => 17.7, '97th' => 20.0],
        45 => ['3rd' => 12.1, '15th' => 13.5, 'median' => 15.5, '85th' => 17.9, '97th' => 20.3],
        46 => ['3rd' => 12.3, '15th' => 13.7, 'median' => 15.7, '85th' => 18.2, '97th' => 20.6],
        47 => ['3rd' => 12.4, '15th' => 13.8, 'median' => 15.9, '85th' => 18.4, '97th' => 20.8],
        48 => ['3rd' => 12.5, '15th' => 14.0, 'median' => 16.1, '85th' => 18.6, '97th' => 21.1],
        49 => ['3rd' => 12.6, '15th' => 14.1, 'median' => 16.3, '85th' => 18.9, '97th' => 21.4],
        50 => ['3rd' => 12.8, '15th' => 14.3, 'median' => 16.4, '85th' => 19.1, '97th' => 21.7],
        51 => ['3rd' => 12.9, '15th' => 14.4, 'median' => 16.6, '85th' => 19.3, '97th' => 22.0],
        52 => ['3rd' => 13.0, '15th' => 14.5, 'median' => 16.8, '85th' => 19.5, '97th' => 22.2],
        53 => ['3rd' => 13.1, '15th' => 14.7, 'median' => 17.0, '85th' => 19.8, '97th' => 22.5],
        54 => ['3rd' => 13.2, '15th' => 14.8, 'median' => 17.2, '85th' => 20.0, '97th' => 22.8],
        55 => ['3rd' => 13.4, '15th' => 15.0, 'median' => 17.3, '85th' => 20.2, '97th' => 23.1],
        56 => ['3rd' => 13.5, '15th' => 15.1, 'median' => 17.5, '85th' => 20.4, '97th' => 23.3],
        57 => ['3rd' => 13.6, '15th' => 15.3, 'median' => 17.7, '85th' => 20.7, '97th' => 23.6],
        58 => ['3rd' => 13.7, '15th' => 15.4, 'median' => 17.9, '85th' => 20.9, '97th' => 23.9],
        59 => ['3rd' => 13.8, '15th' => 15.5, 'median' => 18.0, '85th' => 21.1, '97th' => 24.2],
        60 => ['3rd' => 14.0, '15th' => 15.7, 'median' => 18.2, '85th' => 21.3, '97th' => 24.4],
    ];


    private array $whoWeightForAgeBoys = [
        0 => ['3rd' => 2.5, '15th' => 2.9, 'median' => 3.3, '85th' => 3.9, '97th' => 4.3],
        1 => ['3rd' => 3.4, '15th' => 3.9, 'median' => 4.5, '85th' => 5.1, '97th' => 5.7],
        2 => ['3rd' => 4.4, '15th' => 4.9, 'median' => 5.6, '85th' => 6.3, '97th' => 7.0],
        3 => ['3rd' => 5.1, '15th' => 5.6, 'median' => 6.4, '85th' => 7.2, '97th' => 7.9],
        4 => ['3rd' => 5.6, '15th' => 6.2, 'median' => 7.0, '85th' => 7.9, '97th' => 8.6],
        5 => ['3rd' => 6.1, '15th' => 6.7, 'median' => 7.5, '85th' => 8.4, '97th' => 9.2],
        6 => ['3rd' => 6.4, '15th' => 7.1, 'median' => 7.9, '85th' => 8.9, '97th' => 9.7],
        7 => ['3rd' => 6.7, '15th' => 7.4, 'median' => 8.3, '85th' => 9.3, '97th' => 10.2],
        8 => ['3rd' => 7.0, '15th' => 7.7, 'median' => 8.6, '85th' => 9.6, '97th' => 10.5],
        9 => ['3rd' => 7.2, '15th' => 7.9, 'median' => 8.9, '85th' => 10.0, '97th' => 10.9],
        10 => ['3rd' => 7.5, '15th' => 8.2, 'median' => 9.2, '85th' => 10.3, '97th' => 11.2],
        11 => ['3rd' => 7.7, '15th' => 8.4, 'median' => 9.4, '85th' => 10.5, '97th' => 11.5],
        12 => ['3rd' => 7.8, '15th' => 8.6, 'median' => 9.6, '85th' => 10.8, '97th' => 11.8],
        13 => ['3rd' => 8.0, '15th' => 8.8, 'median' => 9.9, '85th' => 11.1, '97th' => 12.1],
        14 => ['3rd' => 8.2, '15th' => 9.0, 'median' => 10.1, '85th' => 11.3, '97th' => 12.4],
        15 => ['3rd' => 8.4, '15th' => 9.2, 'median' => 10.3, '85th' => 11.6, '97th' => 12.7],
        16 => ['3rd' => 8.5, '15th' => 9.4, 'median' => 10.5, '85th' => 11.8, '97th' => 12.9],
        17 => ['3rd' => 8.7, '15th' => 9.6, 'median' => 10.7, '85th' => 12.0, '97th' => 13.2],
        18 => ['3rd' => 8.9, '15th' => 9.7, 'median' => 10.9, '85th' => 12.3, '97th' => 13.5],
        19 => ['3rd' => 9.0, '15th' => 9.9, 'median' => 11.1, '85th' => 12.5, '97th' => 13.7],
        20 => ['3rd' => 9.2, '15th' => 10.1, 'median' => 11.3, '85th' => 12.7, '97th' => 14.0],
        21 => ['3rd' => 9.3, '15th' => 10.3, 'median' => 11.5, '85th' => 13.0, '97th' => 14.3],
        22 => ['3rd' => 9.5, '15th' => 10.5, 'median' => 11.6, '85th' => 13.2, '97th' => 14.5],
        23 => ['3rd' => 9.7, '15th' => 10.6, 'median' => 12.0, '85th' => 13.4, '97th' => 14.8],
        24 => ['3rd' => 9.8, '15th' => 10.8, 'median' => 12.2, '85th' => 13.7, '97th' => 15.1],
        25 => ['3rd' => 10.0, '15th' => 11.0, 'median' => 12.4, '85th' => 13.9, '97th' => 15.3],
        26 => ['3rd' => 10.1, '15th' => 11.1, 'median' => 12.5, '85th' => 14.1, '97th' => 15.6],
        27 => ['3rd' => 10.2, '15th' => 11.3, 'median' => 12.7, '85th' => 14.4, '97th' => 15.9],
        28 => ['3rd' => 10.4, '15th' => 11.5, 'median' => 12.9, '85th' => 14.6, '97th' => 16.1],
        29 => ['3rd' => 10.5, '15th' => 11.6, 'median' => 13.1, '85th' => 14.8, '97th' => 16.4],
        30 => ['3rd' => 10.7, '15th' => 11.8, 'median' => 13.3, '85th' => 15.0, '97th' => 16.6],
        31 => ['3rd' => 10.8, '15th' => 11.9, 'median' => 13.5, '85th' => 15.2, '97th' => 16.9],
        32 => ['3rd' => 10.9, '15th' => 12.1, 'median' => 13.7, '85th' => 15.5, '97th' => 17.1],
        33 => ['3rd' => 11.1, '15th' => 12.2, 'median' => 13.8, '85th' => 15.7, '97th' => 17.3],
        34 => ['3rd' => 11.2, '15th' => 12.4, 'median' => 14.0, '85th' => 15.9, '97th' => 17.6],
        35 => ['3rd' => 11.3, '15th' => 12.5, 'median' => 14.2, '85th' => 16.1, '97th' => 17.8],
        36 => ['3rd' => 11.4, '15th' => 12.7, 'median' => 14.3, '85th' => 16.3, '97th' => 18.0],
        37 => ['3rd' => 11.6, '15th' => 12.8, 'median' => 14.5, '85th' => 16.5, '97th' => 18.3],
        38 => ['3rd' => 11.7, '15th' => 12.9, 'median' => 14.7, '85th' => 16.7, '97th' => 18.5],
        39 => ['3rd' => 11.8, '15th' => 13.1, 'median' => 14.8, '85th' => 16.9, '97th' => 18.7],
        40 => ['3rd' => 11.9, '15th' => 13.2, 'median' => 15.0, '85th' => 17.1, '97th' => 19.0],
        41 => ['3rd' => 12.1, '15th' => 13.4, 'median' => 15.2, '85th' => 17.3, '97th' => 19.2],
        42 => ['3rd' => 12.2, '15th' => 13.5, 'median' => 15.3, '85th' => 17.5, '97th' => 19.4],
        43 => ['3rd' => 12.3, '15th' => 13.6, 'median' => 15.5, '85th' => 17.7, '97th' => 19.7],
        44 => ['3rd' => 12.4, '15th' => 13.8, 'median' => 15.7, '85th' => 17.9, '97th' => 19.9],
        45 => ['3rd' => 12.5, '15th' => 13.9, 'median' => 15.8, '85th' => 18.1, '97th' => 20.1],
        46 => ['3rd' => 12.7, '15th' => 14.1, 'median' => 16.0, '85th' => 18.3, '97th' => 20.4],
        47 => ['3rd' => 12.8, '15th' => 14.2, 'median' => 16.2, '85th' => 18.5, '97th' => 20.6],
        48 => ['3rd' => 12.9, '15th' => 14.3, 'median' => 16.3, '85th' => 18.7, '97th' => 20.9],
        49 => ['3rd' => 13.0, '15th' => 14.5, 'median' => 16.5, '85th' => 18.9, '97th' => 21.1],
        50 => ['3rd' => 13.1, '15th' => 14.6, 'median' => 16.7, '85th' => 19.1, '97th' => 21.3],
        51 => ['3rd' => 13.3, '15th' => 14.7, 'median' => 16.8, '85th' => 19.3, '97th' => 21.6],
        52 => ['3rd' => 13.4, '15th' => 14.9, 'median' => 17.0, '85th' => 19.5, '97th' => 21.8],
        53 => ['3rd' => 13.5, '15th' => 15.0, 'median' => 17.2, '85th' => 19.7, '97th' => 22.1],
        54 => ['3rd' => 13.6, '15th' => 15.2, 'median' => 17.3, '85th' => 19.9, '97th' => 22.3],
        55 => ['3rd' => 13.7, '15th' => 15.3, 'median' => 17.5, '85th' => 20.1, '97th' => 22.5],
        56 => ['3rd' => 13.8, '15th' => 15.4, 'median' => 17.7, '85th' => 20.3, '97th' => 22.8],
        57 => ['3rd' => 13.9, '15th' => 15.6, 'median' => 17.8, '85th' => 20.5, '97th' => 23.0],
        58 => ['3rd' => 14.1, '15th' => 15.7, 'median' => 18.0, '85th' => 20.7, '97th' => 23.3],
        59 => ['3rd' => 14.2, '15th' => 15.8, 'median' => 18.2, '85th' => 20.9, '97th' => 23.5],
        60 => ['3rd' => 14.3, '15th' => 16.0, 'median' => 18.3, '85th' => 21.1, '97th' => 23.8],
    ];



    public function __construct()
    {
        // Karena whoHeightForAgeGirls sudah dideklarasikan dan diisi langsung
        // di properti, kita tidak perlu memanggil method pemuatan di sini untuknya.
        // Cukup pastikan whoHeightForAgeBoys juga sudah terisi.
        // Jika Anda memuat dari database atau file, konstruktor akan menjadi tempat yang tepat.
    }

    /**
     * Method ini dipanggil oleh controller untuk mendapatkan seluruh data standar Tinggi Badan per Usia
     * untuk jenis kelamin tertentu.
     * Outputnya akan digunakan oleh JavaScript untuk menggambar grafik.
     *
     * @param string $gender 'L' untuk laki-laki, 'P' untuk perempuan
     * @return array
     */
    public function getHeightForAgeStandards(string $gender): array
    {
        $standards = [];
        if (strtoupper($gender) === 'P') {
            foreach ($this->whoHeightForAgeGirls as $usia => $data) { // <--- SESUAIKAN DENGAN NAMA PROPERTI YANG ADA
                $standards[] = array_merge(['usia' => $usia], $data);
            }
        } elseif (strtoupper($gender) === 'L') {
            foreach ($this->whoHeightForAgeBoys as $usia => $data) { // <--- SESUAIKAN DENGAN NAMA PROPERTI YANG ADA
                $standards[] = array_merge(['usia' => $usia], $data);
            }
        }
        return $standards;
    }

  


    /**
     * Menghitung status pertumbuhan Tinggi Badan Berdasarkan Usia.
     * Digunakan untuk menentukan "Sangat Pendek", "Pendek", "Normal", dll.
     *
     * @param int $usiaBulan Usia anak dalam bulan.
     * @param float $tinggiBadan Tinggi badan anak dalam cm.
     * @param string $jenisKelamin 'L' untuk laki-laki, 'P' untuk perempuan.
     * @return array Hasil diagnosis status pertumbuhan.
     */
    public function getGrowthStatusHeightForAge(int $usiaBulan, float $tinggiBadan, string $jenisKelamin): array
    {
        $standardData = null;
        $genderSpecificMessage = '';
        $maxAgeForGender = 0;

        if (strtoupper($jenisKelamin) === 'P') {
            $standardData = $this->whoHeightForAgeGirls;
            $genderSpecificMessage = 'anak perempuan';
            $maxAgeForGender = 60;
        } elseif (strtoupper($jenisKelamin) === 'L') {
            $standardData = $this->whoHeightForAgeBoys;
            $genderSpecificMessage = 'anak laki-laki';
            $maxAgeForGender = 60;
        } else {
            return [
                'status' => 'Error',
                'description' => 'Jenis kelamin tidak valid. Gunakan "L" atau "P".',
                'percentile' => null,
                'standard_data' => null
            ];
        }

        if (!isset($standardData[$usiaBulan]) || $usiaBulan < 0 || $usiaBulan > $maxAgeForGender) {
            return [
                'status' => 'Tidak Tersedia',
                'description' => 'Data standar WHO untuk '. $genderSpecificMessage .' usia '. $usiaBulan .' bulan tidak tersedia (rentang data saat ini 0-'. $maxAgeForGender .' bulan).',
                'percentile' => null,
                'standard_data' => null
            ];
        }

        // Penting: Pastikan kunci-kunci ini ('3rd', '15th', 'median', '85th', '97th') cocok dengan data WHO Anda.
        $standard = $standardData[$usiaBulan];

        $status = 'Normal';
        $description = 'Tinggi badan sesuai usia.';
        $percentile = null;

        // Logika penentuan status gizi berdasarkan persentil
        // Perhatikan bahwa Anda menggunakan kunci '3rd', '15th', 'median', '85th', '97th'
        if ($tinggiBadan < $standard['3rd']) {
            $status = 'Sangat Pendek';
            $description = 'Tinggi badan sangat kurang untuk usia ini (di bawah persentil ke-3).';
            $percentile = '< 3rd';
        } elseif ($tinggiBadan >= $standard['3rd'] && $tinggiBadan < $standard['15th']) {
            $status = 'Pendek';
            $description = 'Tinggi badan kurang untuk usia ini (antara persentil ke-3 dan ke-15).';
            $percentile = '3rd - 15th';
        } elseif ($tinggiBadan >= $standard['15th'] && $tinggiBadan <= $standard['85th']) {
            $status = 'Normal';
            $description = 'Tinggi badan sesuai dengan usia (antara persentil ke-15 dan ke-85).';
            $percentile = '15th - 85th';
        } elseif ($tinggiBadan > $standard['85th'] && $tinggiBadan <= $standard['97th']) {
            $status = 'Tinggi';
            $description = 'Tinggi badan lebih dari rata-rata untuk usia ini (antara persentil ke-85 dan ke-97).';
            $percentile = '85th - 97th';
        } elseif ($tinggiBadan > $standard['97th']) {
            $status = 'Sangat Tinggi';
            $description = 'Tinggi badan sangat tinggi untuk usia ini (di atas persentil ke-97).';
            $percentile = '> 97th';
        }

        return [
            'status' => $status,
            'description' => $description,
            'percentile' => $percentile,
            'standard_data' => $standard
        ];
    }



    public function getWeightForAgeStandards(string $gender): array
    {
        $standards = [];
        if (strtoupper($gender) === 'P') {
            foreach ($this->whoWeightForAgeGirls as $usia => $data) {
                $standards[] = array_merge(['usia' => $usia], $data);
            }
        } elseif (strtoupper($gender) === 'L') {
            foreach ($this->whoWeightForAgeBoys as $usia => $data) {
                $standards[] = array_merge(['usia' => $usia], $data);
            }
        }
        return $standards;
    }

      /**
     * Method ini ada sebagai placeholder. Karena Anda menghapus grafik berat badan,
     * method ini hanya akan mengembalikan array kosong. Jika suatu saat Anda ingin
     * menambahkan kembali grafik berat badan, Anda perlu mengisi method ini
     * dengan logika yang serupa dengan `getHeightForAgeStandards`.
     *
     * @param string $gender 'L' untuk laki-laki, 'P' untuk perempuan
     * @return array
     */
    

    // Metode untuk menghitung status gizi BB/U
    public function getGrowthStatusWeightForAge(int $usia, float $beratBadan, string $gender): array
{
    $standards = $this->getWeightForAgeStandards($gender);

    if (!isset($standards[$usia])) {
        return ['status' => 'Data tidak tersedia', 'description' => 'Standar WHO untuk BB/U tidak tersedia untuk usia ini.'];
    }

    $dataStandard = $standards[$usia];

    $status = 'Normal'; // Default status
    $description = 'Berat badan per usia normal.'; // Default description

    // Logika perhitungan status gizi BB/U berdasarkan persentil WHO
    // Urutan pengecekan penting, dari kondisi paling ekstrem ke normal, atau dari bawah ke atas.

    if ($beratBadan < $dataStandard['3rd']) {
        $status = 'Sangat Kurus';
        $description = 'Berat badan sangat kurang untuk usia anak.';
    } elseif ($beratBadan < $dataStandard['15th']) {
        $status = 'Kurus';
        $description = 'Berat badan kurang untuk usia anak.';
    } elseif ($beratBadan >= $dataStandard['15th'] && $beratBadan <= $dataStandard['85th']) {
        // Ini adalah rentang "Normal" yang eksplisit
        $status = 'Normal';
        $description = 'Berat badan per usia normal.';
    } elseif ($beratBadan > $dataStandard['85th'] && $beratBadan <= $dataStandard['97th']) {
        $status = 'Gemuk'; // Risiko gizi lebih
        $description = 'Berat badan lebih untuk usia anak (risiko gizi lebih).';
    } elseif ($beratBadan > $dataStandard['97th']) {
        $status = 'Sangat Gemuk'; // Obesitas
        $description = 'Obesitas untuk usia anak.';
    }

    return ['status' => $status, 'description' => $description, 'percentile_data' => $dataStandard];
}
    
}