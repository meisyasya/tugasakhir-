<?php

namespace App\Services;

class BalitaGrowthService
{

    // tabel tinggi badan menurut usia
    private $tabelTBperUsia = [
        'L' => [ 
            // Usia (bulan) => [Tinggi Badan -3 SD, Tinggi Badan -2 SD]
            0  => [44.2, 46.1],
            1  => [48.9, 50.8],
            2  => [52.4, 54.4],
            3  => [53.3, 55.3],
            4  => [57.6, 59.7],
            5  => [59.6, 61.7],
            6  => [61.2, 63.3],
            7  => [62.7, 64.8],
            8  => [64.0, 66.2],
            9  => [65.2, 67.5],
            10 => [66.4, 68.7],
            11 => [67.6, 69.9],
            12 => [68.6, 71.0],
            13 => [69.6, 72.1],
            14 => [70.6, 73.1],
            15 => [71.6, 74.1],
            16 => [72.5, 75.0],
            17 => [73.3, 76.0],
            18 => [74.2, 76.9],
            19 => [75.0, 77.7],
            20 => [75.8, 78.6],
            21 => [76.5, 79.4],
            22 => [77.2, 80.2],
            23 => [78.0, 81.0],
            24 => [78.0, 81.0],
            25 => [78.6, 81.7],
            26 => [79.3, 82.5],
            27 => [79.9, 83.1],
            28 => [80.5, 83.8],
            29 => [81.1, 84.5],
            30 => [81.7, 85.1],
            31 => [82.3, 85.7],
            32 => [82.8, 86.4],
            33 => [83.4, 86.9],
            34 => [83.9, 87.5],
            35 => [84.4, 88.1],
            36 => [85.0, 88.7],
            37 => [85.5, 89.2],
            38 => [86.0, 89.8],
            39 => [86.5, 90.3],
            40 => [87.0, 90.9],
            41 => [87.5, 91.4],
            42 => [88.0, 91.9],
            43 => [88.4, 92.4],
            44 => [88.9, 93.0],
            45 => [89.4, 93.5],
            46 => [89.8, 94.0],
            47 => [90.3, 94.4],
            48 => [90.7, 94.9],
            49 => [91.2, 95.4],
            50 => [91.6, 95.9],
            51 => [92.1, 96.4],
            52 => [92.5, 96.9],
            53 => [93.0, 97.4],
            54 => [93.4, 97.8],
            55 => [93.9, 98.3],
            56 => [94.3, 98.8],
            57 => [94.7, 99.3],
            58 => [95.2, 99.7],
            59 => [95.6, 100.2],
            60 => [96.1, 100.7],
        ],

        'P' => [ 
            0  => [43.6, 45.4],
            1  => [47.8, 49.8],
            2  => [51.0, 53.0],
            3  => [53.5, 55.6],
            4  => [55.6, 57.8],
            5  => [57.4, 59.6],
            6  => [58.9, 61.2],
            7  => [60.3, 62.7],
            8  => [61.7, 64.0],
            9  => [62.9, 65.3],
            10 => [64.1, 66.5],
            11 => [65.2, 67.7],
            12 => [66.3, 68.9],
            13 => [67.3, 70.0],
            14 => [68.3, 71.0],
            15 => [69.3, 72.0],
            16 => [70.2, 73.0],
            17 => [71.1, 74.0],
            18 => [72.0, 74.9],
            19 => [72.8, 75.8],
            20 => [73.7, 76.7],
            21 => [74.5, 77.5],
            22 => [75.2, 78.4],
            23 => [76.0, 79.2],
            24 => [76.0, 79.3], 
            25 => [76.8, 80.0],
            26 => [77.5, 80.8],
            27 => [78.1, 81.5],
            28 => [78.8, 82.2],
            29 => [79.5, 82.9],
            30 => [80.1, 83.6],
            31 => [80.7, 84.3],
            32 => [81.3, 84.9],
            33 => [81.9, 85.6],
            34 => [82.5, 86.2],
            35 => [83.1, 86.8],
            36 => [83.6, 87.4],
            37 => [84.2, 88.0],
            38 => [84.7, 88.6],
            39 => [85.3, 89.2],
            40 => [85.8, 89.8],
            41 => [86.3, 90.4],
            42 => [86.8, 90.9],
            43 => [87.4, 91.5],
            44 => [87.9, 92.0],
            45 => [88.4, 92.5],
            46 => [88.9, 93.1],
            47 => [89.3, 93.6],
            48 => [89.8, 94.1],
            49 => [90.3, 94.6],
            50 => [90.7, 95.1],
            51 => [91.2, 95.6],
            52 => [91.7, 96.1],
            53 => [92.1, 96.6],
            54 => [92.6, 97.1],
            55 => [93.0, 97.6],
            56 => [93.4, 98.1],
            57 => [93.9, 98.5],
            58 => [94.3, 99.0],
            59 => [94.7, 99.5],
            60 => [95.2, 99.9],
        ]
    ];


    // tabel berat badan menurut usia
    private $tabelWeightForAgeBoys = [
        0  => [2.1, 2.5, 3.3, 4.4, 5.0],
        1  => [2.9, 3.4, 4.5, 6.1, 6.8],
        2  => [3.8, 4.3, 5.4, 7.1, 8.0],
        3  => [4.4, 5.0, 6.4, 7.8, 8.7],
        4  => [4.9, 5.6, 7.0, 8.7, 9.7],
        5  => [5.3, 6.0, 7.5, 9.3, 10.4],
        6  => [5.7, 6.4, 7.9, 9.8, 10.9],
        7  => [5.9, 6.7, 8.3, 10.3, 11.4],
        8  => [6.2, 6.9, 8.6, 10.7, 11.9],
        9  => [6.4, 7.1, 8.9, 11.0, 12.3],
        10 => [6.6, 7.4, 9.2, 11.4, 12.7],
        11 => [6.8, 7.6, 9.4, 11.7, 13.0],
        12 => [6.9, 7.7, 9.6, 12.0, 13.3],
        13 => [7.1, 7.9, 9.9, 12.3, 13.7],
        14 => [7.2, 8.1, 10.1, 12.6, 14.0],
        15 => [7.4, 8.3, 10.3, 12.8, 14.3],
        16 => [7.5, 8.4, 10.5, 13.1, 14.6],
        17 => [7.7, 8.6, 10.7, 13.4, 14.9],
        18 => [7.8, 8.8, 10.9, 13.7, 15.3],
        19 => [8.0, 8.9, 11.1, 13.9, 15.6],
        20 => [8.1, 9.1, 11.3, 14.2, 15.9],
        21 => [8.2, 9.2, 11.5, 14.5, 16.2],
        22 => [8.4, 9.4, 11.8, 14.7, 16.5],
        23 => [8.5, 9.5, 12.0, 15.0, 16.8],
        24 => [8.6, 9.7, 12.2, 15.3, 17.1],
        25 => [8.8, 9.8, 12.4, 15.5, 17.5],
        26 => [8.9, 10.0, 12.5, 15.8, 17.8],
        27 => [9.0, 10.1, 12.7, 16.1, 18.1],
        28 => [9.1, 10.2, 12.9, 16.3, 18.4],
        29 => [9.2, 10.4, 13.1, 16.6, 18.7],
        30 => [9.4, 10.5, 13.3, 16.9, 19.0],
        31 => [9.5, 10.7, 13.5, 17.1, 19.3],
        32 => [9.6, 10.8, 13.7, 17.4, 19.6],
        33 => [9.7, 10.9, 13.8, 17.6, 19.9],
        34 => [9.8, 11.0, 14.0, 17.8, 20.2],
        35 => [9.9, 11.2, 14.2, 18.1, 20.4],
        36 => [10.0, 11.3, 14.3, 18.3, 20.7],
        37 => [10.1, 11.4, 14.5, 18.6, 21.0],
        38 => [10.2, 11.5, 14.7, 18.8, 21.3],
        39 => [10.3, 11.6, 14.8, 19.0, 21.6],
        40 => [10.4, 11.8, 15.0, 19.3, 21.9],
        41 => [10.5, 11.9, 15.2, 19.5, 22.1],
        42 => [10.6, 12.0, 15.3, 19.7, 22.4],
        43 => [10.7, 12.1, 15.5, 20.0, 22.7],
        44 => [10.8, 12.2, 15.7, 20.2, 23.0],
        45 => [10.9, 12.4, 15.8, 20.5, 23.3],
        46 => [11.0, 12.5, 16.0, 20.7, 23.6],
        47 => [11.1, 12.6, 16.2, 20.9, 23.9],
        48 => [11.2, 12.7, 16.3, 21.2, 24.2],
        49 => [11.3, 12.8, 16.5, 21.4, 24.5],
        50 => [11.4, 12.9, 16.7, 21.7, 24.8],
        51 => [11.5, 13.1, 16.8, 21.9, 25.1],
        52 => [11.6, 13.2, 17.0, 22.2, 25.4],
        53 => [11.7, 13.3, 17.2, 22.4, 25.7],
        54 => [11.8, 13.4, 17.3, 22.7, 26.0],
        55 => [11.9, 13.5, 17.5, 22.9, 26.3],
        56 => [12.0, 13.6, 17.7, 23.2, 26.6],
        57 => [12.1, 13.7, 17.8, 23.4, 26.9],
        58 => [12.2, 13.8, 18.0, 23.7, 27.2],
        59 => [12.3, 14.0, 18.2, 23.9, 27.6],
        60 => [12.4, 14.1, 18.3, 24.2, 27.9],
    ];

    private $tabelWeightForAgeGirls = [
        0  => [2.0, 2.4, 3.2, 4.3, 4.8],
        1  => [2.7, 3.2, 4.2, 5.7, 6.2],
        2  => [3.4, 3.9, 5.1, 6.6, 7.5],
        3  => [4.0, 4.5, 5.8, 7.3, 8.5],
        4  => [4.4, 5.0, 6.4, 7.9, 9.3],
        5  => [4.8, 5.4, 6.9, 8.3, 10.0],
        6  => [5.1, 5.7, 7.3, 8.8, 10.6],
        7  => [5.3, 6.0, 7.6, 9.3, 11.1],
        8  => [5.6, 6.3, 7.9, 9.7, 11.6],
        9  => [5.8, 6.5, 8.2, 10.0, 12.0],
        10 => [5.9, 6.7, 8.5, 10.3, 12.4],
        11 => [6.1, 6.9, 8.7, 10.6, 12.8],
        12 => [6.3, 7.0, 8.9, 10.9, 13.1],
        13 => [6.4, 7.2, 9.1, 11.1, 13.5],
        14 => [6.6, 7.4, 9.3, 11.4, 13.8],
        15 => [6.7, 7.6, 9.6, 11.7, 14.1],
        16 => [6.9, 7.7, 9.8, 11.9, 14.5],
        17 => [7.0, 7.9, 10.0, 12.2, 14.8],
        18 => [7.2, 8.1, 10.2, 12.5, 15.1],
        19 => [7.3, 8.2, 10.4, 12.7, 15.4],
        20 => [7.5, 8.4, 10.6, 13.0, 15.7],
        21 => [7.6, 8.6, 10.8, 13.2, 16.0],
        22 => [7.8, 8.7, 11.0, 13.5, 16.4],
        23 => [7.9, 8.9, 11.1, 13.8, 16.7],
        24 => [8.1, 9.0, 11.3, 14.0, 17.0],
        25 => [8.2, 9.2, 11.5, 14.3, 17.3],
        26 => [8.4, 9.4, 11.7, 14.5, 17.7],
        27 => [8.5, 9.5, 11.9, 14.8, 18.0],
        28 => [8.6, 9.7, 12.1, 15.0, 18.3],
        29 => [8.8, 9.8, 12.2, 15.3, 18.7],
        30 => [8.9, 10.0, 12.4, 15.5, 19.0],
        31 => [9.0, 10.1, 12.6, 15.8, 19.3],
        32 => [9.1, 10.3, 12.8, 16.0, 19.6],
        33 => [9.2, 10.4, 12.9, 16.3, 19.9],
        34 => [9.4, 10.5, 13.1, 16.5, 20.2],
        35 => [9.5, 10.7, 13.3, 16.8, 20.5],
        36 => [9.6, 10.8, 13.5, 17.0, 20.8],
        37 => [9.7, 10.9, 13.6, 17.2, 21.0],
        38 => [9.8, 11.1, 13.8, 17.5, 21.3],
        39 => [9.9, 11.2, 14.0, 17.7, 21.6],
        40 => [10.0, 11.3, 14.2, 17.9, 21.9],
        41 => [10.1, 11.5, 14.3, 18.2, 22.2],
        42 => [10.2, 11.6, 14.5, 18.4, 22.5],
        43 => [10.3, 11.7, 14.7, 18.7, 22.8],
        44 => [10.4, 11.8, 14.8, 18.9, 23.1],
        45 => [10.5, 12.0, 15.0, 19.2, 23.4],
        46 => [10.6, 12.1, 15.2, 19.4, 23.7],
        47 => [10.7, 12.2, 15.3, 19.6, 24.0],
        48 => [10.8, 12.3, 15.5, 19.9, 24.3],
        49 => [10.9, 12.4, 15.7, 20.1, 24.6],
        50 => [11.0, 12.6, 15.8, 20.4, 24.9],
        51 => [11.1, 12.7, 16.0, 20.6, 25.2],
        52 => [11.2, 12.8, 16.2, 20.9, 25.5],
        53 => [11.3, 12.9, 16.3, 21.1, 25.8],
        54 => [11.4, 13.0, 16.5, 21.4, 26.1],
        55 => [11.5, 13.2, 16.7, 21.6, 26.4],
        56 => [11.6, 13.3, 16.8, 21.9, 26.7],
        57 => [11.7, 13.4, 17.0, 22.1, 27.0],
        58 => [11.8, 13.5, 17.2, 22.4, 27.3],
        59 => [11.9, 13.6, 17.3, 22.6, 27.6],
        60 => [12.0, 13.7, 17.5, 22.9, 27.9],
    ];

    // Data IMT/U (BMI-for-age) untuk Laki-laki 0-60 bulan
    private $tabelBMIBoys = [
        // Usia (Bulan) => [ -3 SD, -2 SD, -1 SD, Median (0 SD), +1 SD, +2 SD, +3 SD ]
        // Data dari WHO Child Growth Standards: BMI-for-age Boys Birth to 5 years (z-scores)
        // Untuk 0-23 bulan dari "BMI-for-age BOYS Birth to 2 years (z-scores)"
        // Untuk 24-60 bulan dari "Simplified field tables BMI-for-age BOYS 2 to 5 years (z-scores)"
        0  => [10.2, 11.1, 12.2, 13.4, 14.8, 16.3, 18.1],
        1  => [11.3, 12.4, 13.6, 14.9, 16.3, 17.8, 19.4],
        2  => [12.5, 13.7, 15.0, 16.3, 17.8, 19.4, 21.1],
        3  => [13.1, 14.3, 15.5, 16.9, 18.4, 20.0, 21.8],
        4  => [13.4, 14.5, 15.8, 17.2, 18.7, 20.3, 22.1],
        5  => [13.5, 14.7, 15.9, 17.3, 18.8, 20.5, 22.3],
        6  => [13.6, 14.7, 16.0, 17.3, 18.8, 20.5, 22.3],
        7  => [13.7, 14.8, 16.0, 17.3, 18.8, 20.5, 22.3],
        8  => [13.6, 14.7, 15.9, 17.3, 18.7, 20.4, 22.2],
        9  => [13.6, 14.7, 15.8, 17.2, 18.6, 20.3, 22.1],
        10 => [13.5, 14.6, 15.7, 17.0, 18.5, 20.1, 22.0],
        11 => [13.4, 14.5, 15.6, 16.9, 18.4, 20.0, 21.8],
        12 => [13.4, 14.4, 15.5, 16.8, 18.2, 19.8, 21.6],
        13 => [13.3, 14.3, 15.4, 16.7, 18.1, 19.7, 21.5],
        14 => [13.2, 14.2, 15.3, 16.6, 18.0, 19.5, 21.3],
        15 => [13.1, 14.1, 15.2, 16.4, 17.8, 19.4, 21.2],
        16 => [13.0, 14.0, 15.1, 16.3, 17.7, 19.3, 21.0],
        17 => [13.0, 13.9, 15.0, 16.2, 17.6, 19.1, 20.9],
        18 => [12.9, 13.9, 14.9, 16.1, 17.5, 19.0, 20.8],
        19 => [12.9, 13.8, 14.9, 16.1, 17.4, 18.9, 20.7],
        20 => [12.8, 13.7, 14.8, 16.0, 17.3, 18.8, 20.6],
        21 => [12.8, 13.7, 14.7, 15.9, 17.2, 18.7, 20.5],
        22 => [12.7, 13.6, 14.7, 15.8, 17.1, 18.7, 20.4],
        23 => [12.7, 13.6, 14.6, 15.8, 17.1, 18.6, 20.3],
        24 => [12.9, 13.8, 14.8, 16.0, 17.3, 18.9, 20.6],
        25 => [12.8, 13.7, 14.8, 16.0, 17.3, 18.8, 20.5],
        26 => [12.8, 13.7, 14.7, 15.9, 17.3, 18.8, 20.5],
        27 => [12.7, 13.7, 14.7, 15.9, 17.2, 18.7, 20.4],
        28 => [12.7, 13.6, 14.7, 15.9, 17.2, 18.7, 20.4],
        29 => [12.7, 13.6, 14.7, 15.8, 17.1, 18.6, 20.3],
        30 => [12.6, 13.6, 14.6, 15.8, 17.1, 18.6, 20.2],
        31 => [12.6, 13.5, 14.6, 15.8, 17.1, 18.5, 20.2],
        32 => [12.6, 13.5, 14.6, 15.7, 17.0, 18.5, 20.1],
        33 => [12.5, 13.5, 14.5, 15.7, 17.0, 18.5, 20.1],
        34 => [12.5, 13.4, 14.5, 15.7, 17.0, 18.4, 20.0],
        35 => [12.4, 13.4, 14.5, 15.6, 16.9, 18.4, 20.0],
        36 => [12.4, 13.4, 14.4, 15.6, 16.9, 18.4, 20.0],
        37 => [12.4, 13.3, 14.4, 15.6, 16.9, 18.3, 19.9],
        38 => [12.3, 13.3, 14.4, 15.5, 16.8, 18.3, 19.9],
        39 => [12.3, 13.3, 14.3, 15.5, 16.8, 18.3, 19.9],
        40 => [12.3, 13.2, 14.3, 15.5, 16.8, 18.2, 19.9],
        41 => [12.2, 13.2, 14.3, 15.5, 16.8, 18.2, 19.9],
        42 => [12.2, 13.2, 14.3, 15.4, 16.8, 18.2, 19.8],
        43 => [12.2, 13.2, 14.2, 15.4, 16.7, 18.2, 19.8],
        44 => [12.2, 13.1, 14.2, 15.4, 16.7, 18.2, 19.8],
        45 => [12.2, 13.1, 14.2, 15.4, 16.7, 18.2, 19.8],
        46 => [12.1, 13.1, 14.2, 15.4, 16.7, 18.2, 19.8],
        47 => [12.1, 13.1, 14.2, 15.3, 16.7, 18.2, 19.9],
        48 => [12.1, 13.1, 14.1, 15.3, 16.7, 18.2, 19.9],
        49 => [12.1, 13.0, 14.1, 15.3, 16.7, 18.2, 19.9],
        50 => [12.1, 13.0, 14.1, 15.3, 16.7, 18.2, 19.9],
        51 => [12.1, 13.0, 14.1, 15.3, 16.6, 18.2, 19.9],
        52 => [12.0, 13.0, 14.1, 15.3, 16.6, 18.2, 19.9],
        53 => [12.0, 13.0, 14.1, 15.3, 16.6, 18.2, 20.0],
        54 => [12.0, 13.0, 14.0, 15.3, 16.6, 18.2, 20.0],
        55 => [12.0, 13.0, 14.0, 15.2, 16.6, 18.2, 20.0],
        56 => [12.0, 12.9, 14.0, 15.2, 16.6, 18.2, 20.1],
        57 => [12.0, 12.9, 14.0, 15.2, 16.6, 18.2, 20.1],
        58 => [12.0, 12.9, 14.0, 15.2, 16.6, 18.3, 20.2],
        59 => [12.0, 12.9, 14.0, 15.2, 16.6, 18.3, 20.2],
        60 => [12.0, 12.9, 14.0, 15.2, 16.6, 18.3, 20.3],
    ];
    // Data IMT/U (BMI-for-age) untuk Perempuan 0-60 bulan
    private $tabelBMIGirls = [
        0  => [10.1, 10.8, 11.6, 12.6, 13.6, 14.8, 16.1],
        1  => [10.8, 12.0, 13.2, 14.6, 16.0, 17.5, 19.1],
        2  => [11.8, 13.0, 14.3, 15.8, 17.3, 19.0, 20.7],
        3  => [12.4, 13.6, 14.9, 16.4, 17.9, 19.7, 21.5],
        4  => [12.7, 13.9, 15.2, 16.7, 18.3, 20.0, 22.0],
        5  => [12.9, 14.1, 15.4, 16.8, 18.4, 20.2, 22.2],
        6  => [13.0, 14.1, 15.5, 16.9, 18.5, 20.3, 22.3],
        7  => [13.0, 14.2, 15.5, 16.9, 18.5, 20.3, 22.3],
        8  => [13.0, 14.1, 15.4, 16.8, 18.4, 20.2, 22.2],
        9  => [12.9, 14.1, 15.3, 16.7, 18.3, 20.1, 22.1],
        10 => [12.9, 14.0, 15.2, 16.6, 18.2, 19.9, 21.9],
        11 => [12.8, 13.9, 15.1, 16.5, 18.0, 19.8, 21.8],
        12 => [12.7, 13.8, 15.0, 16.4, 17.9, 19.6, 21.6],
        13 => [12.6, 13.7, 14.9, 16.2, 17.7, 19.5, 21.4],
        14 => [12.6, 13.6, 14.8, 16.1, 17.6, 19.3, 21.3],
        15 => [12.5, 13.5, 14.7, 16.0, 17.5, 19.2, 21.1],
        16 => [12.4, 13.5, 14.6, 15.9, 17.4, 19.1, 21.0],
        17 => [12.4, 13.4, 14.5, 15.8, 17.3, 18.9, 20.9],
        18 => [12.3, 13.3, 14.4, 15.7, 17.2, 18.8, 20.8],
        19 => [12.3, 13.3, 14.4, 15.7, 17.1, 18.8, 20.7],
        20 => [12.2, 13.2, 14.3, 15.6, 17.0, 18.7, 20.6],
        21 => [12.2, 13.2, 14.3, 15.5, 17.0, 18.6, 20.5],
        22 => [12.2, 13.1, 14.2, 15.5, 16.9, 18.5, 20.4],
        23 => [12.1, 13.1, 14.2, 15.4, 16.9, 18.5, 20.4],
        24 => [12.1, 13.1, 14.2, 15.4, 16.8, 18.4, 20.3],
        25 => [12.0, 13.0, 14.1, 15.3, 16.8, 18.3, 20.2],
        26 => [12.0, 12.9, 14.0, 15.2, 16.7, 18.2, 20.1],
        27 => [11.9, 12.9, 14.0, 15.1, 16.6, 18.1, 20.0],
        28 => [11.9, 12.8, 13.9, 15.0, 16.5, 18.0, 19.9],
        29 => [11.8, 12.8, 13.8, 15.0, 16.4, 17.9, 19.8],
        30 => [11.8, 12.7, 13.8, 14.9, 16.3, 17.8, 19.7],
        31 => [11.7, 12.7, 13.7, 14.8, 16.2, 17.7, 19.6],
        32 => [11.7, 12.6, 13.7, 14.7, 16.2, 17.6, 19.5],
        33 => [11.6, 12.6, 13.6, 14.7, 16.1, 17.5, 19.4],
        34 => [11.6, 12.5, 13.6, 14.6, 16.0, 17.5, 19.4],
        35 => [11.5, 12.5, 13.5, 14.6, 16.0, 17.4, 19.3],
        36 => [11.5, 12.4, 13.5, 14.5, 15.9, 17.3, 19.2],
        37 => [11.4, 12.4, 13.4, 14.4, 15.8, 17.3, 19.1],
        38 => [11.4, 12.3, 13.4, 14.4, 15.8, 17.2, 19.1],
        39 => [11.3, 12.3, 13.3, 14.3, 15.7, 17.1, 19.0],
        40 => [11.3, 12.2, 13.3, 14.3, 15.7, 17.1, 18.9],
        41 => [11.2, 12.2, 13.2, 14.2, 15.6, 17.0, 18.9],
        42 => [11.2, 12.1, 13.2, 14.2, 15.6, 17.0, 18.8],
        43 => [11.1, 12.1, 13.1, 14.1, 15.5, 16.9, 18.8],
        44 => [11.1, 12.0, 13.1, 14.1, 15.5, 16.9, 18.7],
        45 => [11.0, 12.0, 13.0, 14.0, 15.4, 16.8, 18.7],
        46 => [11.0, 11.9, 13.0, 14.0, 15.4, 16.8, 18.6],
        47 => [10.9, 11.9, 12.9, 13.9, 15.3, 16.7, 18.6],
        48 => [10.9, 11.8, 12.9, 13.9, 15.3, 16.7, 18.5],
        49 => [10.8, 11.8, 12.8, 13.8, 15.2, 16.6, 18.5],
        50 => [10.8, 11.7, 12.8, 13.8, 15.2, 16.6, 18.4],
        51 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.4],
        52 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        53 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        54 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        55 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        56 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        57 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        58 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        59 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
        60 => [10.7, 11.7, 12.7, 13.7, 15.1, 16.5, 18.3],
    ];

    /**
     * Fungsi untuk mengecek status stunting balita berdasarkan tinggi badan, usia, dan jenis kelamin.
     * Menggunakan standar WHO (Tinggi Badan per Usia - TB/U).
     * Klasifikasi:
     * - Sangat Pendek: < -3.0 SD
     * - Pendek: -3.0 SD s/d < -2.0 SD
     * - Normal: >= -2.0 SD
     *
     * @param float $tinggiBadan Tinggi badan anak dalam cm.
     * @param int $usia Usia anak dalam bulan (0-60).
     * @param string $jenisKelamin Jenis kelamin anak ('L' untuk laki-laki, 'P' untuk perempuan).
     * @return string Status stunting: "Sangat Pendek", "Pendek", "Normal", atau pesan error.
     */
    public function cekStunting(float $tinggiBadan, int $usia, string $jenisKelamin): string
    {
        $jenisKelamin = strtoupper($jenisKelamin);

        // Jika tidak ada ('L' atau 'P'), mengembalikan pesan error.
        if (!isset($this->tabelTBperUsia[$jenisKelamin])) {
            return "Error: Jenis kelamin tidak valid. Gunakan 'L' untuk laki-laki atau 'P' untuk perempuan.";
        }

        if ($usia < 0 || $usia > 60) {
            return "Error: Usia tidak valid. Usia harus antara 0 hingga 60 bulan.";
        }

        if ($tinggiBadan <= 0) {
            return "Error: Tinggi badan harus lebih dari nol.";
        }

        // Cari usia terdekat dalam tabel (pembulatan ke bawah)
        $usiaTerdekat = 0;
        foreach (array_keys($this->tabelTBperUsia[$jenisKelamin]) as $u) {
            if ($usia >= $u) {
                $usiaTerdekat = $u;
            }
        }

        // Setelah menemukan usia terdekat, cek lagi apakah entri untuk usia tersebut benar-benar ada di tabel.
        // Ini adalah langkah keamanan tambahan jika logika `$usiaTerdekat` tidak selalu menemukan kecocokan yang diinginkan.
        if (!isset($this->tabelTBperUsia[$jenisKelamin][$usiaTerdekat])) {
            return "Error: Data referensi tinggi badan/panjang badan tidak tersedia untuk usia ini.";
        }

        // Mengambil array dua nilai standar dari tabel referensi berdasarkan jenis kelamin dan usia terdekat.
        // Destructuring assignment:
        // - $min3SD_TB akan mendapatkan nilai dari indeks 0 (yaitu ambang batas -3 SD).
        // - $min2SD_TB akan mendapatkan nilai dari indeks 1 (yaitu ambang batas -2 SD).
        [$min3SD_TB, $min2SD_TB] = $this->tabelTBperUsia[$jenisKelamin][$usiaTerdekat];

        if ($tinggiBadan < $min3SD_TB) {
            return "Stunting Berat";
        } elseif ($tinggiBadan >= $min3SD_TB && $tinggiBadan < $min2SD_TB) {
            return "Stunting Ringan";
        } else {
            return "Tidak Stunting";
        }
    }
  

    

    /**
     * Fungsi untuk mengecek status gizi balita berdasarkan berat badan, usia, dan jenis kelamin (Weight-for-age / BB/U).
     * Menggunakan standar WHO.
     * Klasifikasi:
     * - Gizi Buruk: < -3.0 SD
     * - Gizi Kurang: -3.0 SD s/d < -2.0 SD
     * - Gizi Baik: -2.0 SD s/d 2.0 SD
     * - Gizi Lebih: > 2.0 SD
     *
     * @param float $beratBadan Berat badan anak dalam kg.
     * @param int $usia Usia anak dalam bulan (0-60).
     * @param string $jenisKelamin Jenis kelamin anak ('L' untuk laki-laki, 'P' untuk perempuan).
     * @return string Status gizi: "Gizi Buruk", "Gizi Kurang", "Gizi Baik", "Gizi Lebih", atau pesan error.
     */
    public function hitungStatusGizi(float $beratBadan, int $usia, string $jenisKelamin): string
    {
        $jenisKelamin = strtoupper($jenisKelamin);

        $tabelReferensi = [];
        if ($jenisKelamin === 'L') {
            $tabelReferensi = $this->tabelWeightForAgeBoys;
        } elseif ($jenisKelamin === 'P') {
            $tabelReferensi = $this->tabelWeightForAgeGirls;
        } else {
            return "Error: Jenis kelamin tidak valid. Gunakan 'L' untuk laki-laki atau 'P' untuk perempuan.";
        }

        if ($usia < 0 || $usia > 60) {
            return "Error: Usia tidak valid. Usia harus antara 0 hingga 60 bulan.";
        }

        if ($beratBadan <= 0) {
            return "Error: Berat badan harus lebih dari nol.";
        }

        // Cari usia terdekat dalam tabel.
        $usiaTerdekat = 0;
        foreach (array_keys($tabelReferensi) as $u) {
            if ($usia >= $u) {
                $usiaTerdekat = $u;
            }
        }

        if (!isset($tabelReferensi[$usiaTerdekat])) {
            return "Error: Data referensi berat badan per usia tidak tersedia untuk usia ini.";
        }

        // Ambil data Z-score untuk usia dan jenis kelamin yang sesuai
        $dataZScore = $tabelReferensi[$usiaTerdekat];

        // Memastikan ada -3SD, -2SD, Median, +2SD, +3SD (5 elemen)
        if (count($dataZScore) < 5) {
            return "Error: Data referensi tidak lengkap untuk usia ini (membutuhkan -3SD, -2SD, Median, +2SD, +3SD).";
        }

        $min3SD = $dataZScore[0];
        $min2SD = $dataZScore[1];
        $plus2SD = $dataZScore[3]; // Indeks 3 untuk +2SD

        // Lakukan klasifikasi berdasarkan berat badan dan batas Z-score (BB/U)
        if ($beratBadan < $min3SD) {
            return "Gizi Buruk";
        } elseif ($beratBadan >= $min3SD && $beratBadan < $min2SD) {
            return "Gizi Kurang";
        } elseif ($beratBadan >= $min2SD && $beratBadan <= $plus2SD) {
            return "Gizi Baik";
        } elseif ($beratBadan > $plus2SD) {
            return "Gizi Lebih";
        } else {
            return "Tidak Terklasifikasi";
        }
    }



    /**
     * Fungsi untuk mengecek status gizi balita berdasarkan IMT, usia, dan jenis kelamin.
     * Menggunakan standar WHO (IMT per Usia - IMT/U).
     * Klasifikasi:
     * - Gizi Buruk: < -3.0 SD
     * - Gizi Kurang: -3.0 SD s/d < -2.0 SD
     * - Gizi Baik: -2.0 SD s/d +1.0 SD
     * - Berisiko Gizi Lebih: > +1.0 SD s/d +2.0 SD
     * - Gizi Lebih: > +2.0 SD s/d +3.0 SD
     * - Obesitas: > +3.0 SD
     *
     * @param float $beratBadan Berat badan anak dalam kg.
     * @param float $tinggiBadan Tinggi badan anak dalam cm.
     * @param int $usia Usia anak dalam bulan (0-60).
     * @param string $jenisKelamin Jenis kelamin anak ('L' untuk laki-laki, 'P' untuk perempuan).
     * @return string Status gizi (IMT/U): "Gizi Buruk", "Gizi Kurang", "Gizi Baik", "Berisiko Gizi Lebih", "Gizi Lebih", "Obesitas", atau pesan error.
     */
    


    public function cekGiziIMT(float $imt, int $usia, string $jenisKelamin): string
{
    $jenisKelamin = strtoupper($jenisKelamin);

    $tabelReferensi = [];
    if ($jenisKelamin === 'L') {
        $tabelReferensi = $this->tabelBMIBoys;
    } elseif ($jenisKelamin === 'P') {
        $tabelReferensi = $this->tabelBMIGirls;
    } else {
        return "Error: Jenis kelamin tidak valid. Gunakan 'L' untuk laki-laki atau 'P' untuk perempuan.";
    }

    if ($usia < 0 || $usia > 60) {
        return "Error: Usia tidak valid. Usia harus antara 0 hingga 60 bulan.";
    }

    if ($imt <= 0) {
        return "Error: IMT harus lebih dari nol.";
    }

    $usiaTerdekat = 0;
    foreach (array_keys($tabelReferensi) as $u) {
        if ($usia >= $u) {
            $usiaTerdekat = $u;
        }
    }

    if (!isset($tabelReferensi[$usiaTerdekat])) {
        return "Error: Data referensi IMT per usia tidak tersedia untuk usia ini.";
    }

    $dataZScore = $tabelReferensi[$usiaTerdekat];

    if (count($dataZScore) < 7) { // Memastikan ada -3SD, -2SD, -1SD, Median, +1SD, +2SD, +3SD
        return "Error: Data referensi IMT/U tidak lengkap untuk usia ini (membutuhkan -3SD s/d +3SD).";
    }

    list($min3SD, $min2SD, $min1SD, $medianSD, $plus1SD, $plus2SD, $plus3SD) = $dataZScore;

    // Klasifikasi 6 kategori
    if ($imt < $min3SD) {
        return "Sangat Kurus";
    } elseif ($imt >= $min3SD && $imt < $min2SD) {
        return "Kurus";
    } elseif ($imt >= $min2SD && $imt <= $plus1SD) { // Normal: -2.0 SD s/d +1.0 SD
        return "Normal";
    } elseif ($imt > $plus1SD && $imt <= $plus2SD) { // Berisiko Gizi Lebih: > +1.0 SD s/d +2.0 SD
        return "Berisiko Gizi Lebih";
    } elseif ($imt > $plus2SD && $imt <= $plus3SD) { // Gizi Lebih: > +2.0 SD s/d +3.0 SD
        return "Gizi Lebih";
    } elseif ($imt > $plus3SD) { // Obesitas: > +3.0 SD
        return "Obesitas";
    } else {
        return "Tidak Terklasifikasi";
    }
}




public function getStandarTinggiBadan(int $usiaBulan, string $jenisKelamin): ?array
{
    $jenisKelamin = strtoupper($jenisKelamin); // Pastikan jenis kelamin di-uppercase

    // Pembulatan ke bawah untuk usia terdekat, sama seperti di cekStunting
    $usiaTerdekat = 0;
    if (isset($this->tabelTBperUsia[$jenisKelamin])) {
        foreach (array_keys($this->tabelTBperUsia[$jenisKelamin]) as $u) {
            if ($usiaBulan >= $u) {
                $usiaTerdekat = $u;
            }
        }
    }

    if (!isset($this->tabelTBperUsia[$jenisKelamin][$usiaTerdekat])) {
        return null;
    }

    [$min3SD_TB, $min2SD_TB] = $this->tabelTBperUsia[$jenisKelamin][$usiaTerdekat];

    $overall_min_tb_data = PHP_FLOAT_MAX;
    foreach ($this->tabelTBperUsia as $genderData) {
        foreach ($genderData as $ageData) {
            $overall_min_tb_data = min($overall_min_tb_data, $ageData[0]);
        }
    }
    $overall_min_tb = max(0, floor($overall_min_tb_data - 5));

    $overall_max_tb_data = 0;
    foreach ($this->tabelTBperUsia as $genderData) {
        foreach ($genderData as $ageData) {
            $overall_max_tb_data = max($overall_max_tb_data, $ageData[1]);
        }
    }
    $overall_max_tb = ceil($overall_max_tb_data + 5);

    return [
        'ranges' => [
            'red' => [0, $min3SD_TB - 0.1], // Batas atas untuk merah
            'yellow' => [$min3SD_TB, $min2SD_TB - 0.1], // Batas bawah kuning adalah $min3SD_TB, batas atas adalah ($min2SD_TB - 0.1)
            'green' => [$min2SD_TB, $overall_max_tb], // Batas bawah hijau adalah $min2SD_TB, batas atas adalah $overall_max_tb
        ],
        'overall_min' => $overall_min_tb,
        'overall_max' => $overall_max_tb,
    ];
}

public function getStandarIMT(int $usiaBulan, string $jenisKelamin): ?array
    {
        $jenisKelamin = strtoupper($jenisKelamin);

        $tabelReferensi = null;
        if ($jenisKelamin === 'L') {
            $tabelReferensi = $this->tabelBMIBoys;
        } elseif ($jenisKelamin === 'P') {
            $tabelReferensi = $this->tabelBMIGirls;
        } else {
            return null;
        }

        if ($tabelReferensi === null) {
            return null;
        }

        $usiaTerdekat = 0;
        foreach (array_keys($tabelReferensi) as $u) {
            if ($usiaBulan >= $u) {
                $usiaTerdekat = $u;
            }
        }

        if (!isset($tabelReferensi[$usiaTerdekat])) {
            return null;
        }

        $dataZScore = $tabelReferensi[$usiaTerdekat];

        if (count($dataZScore) < 7) {
            return null;
        }

        list($min3SD, $min2SD, $min1SD, $medianSD, $plus1SD, $plus2SD, $plus3SD) = $dataZScore;

        $overall_min_imt_data = PHP_FLOAT_MAX;
        $overall_max_imt_data = 0;

        foreach ($this->tabelBMIBoys as $data) {
            $overall_min_imt_data = min($overall_min_imt_data, $data[0]); // -3SD
            $overall_max_imt_data = max($overall_max_imt_data, $data[6]); // +3SD
        }

        foreach ($this->tabelBMIGirls as $data) {
            $overall_min_imt_data = min($overall_min_imt_data, $data[0]); // -3SD
            $overall_max_imt_data = max($overall_max_imt_data, $data[6]); // +3SD
        }

        $overall_min_imt = floor($overall_min_imt_data - 1); // Buffer 1 unit di bawah min WHO
        $overall_max_imt = ceil($overall_max_imt_data + 1); // Buffer 1 unit di atas max WHO

        // Kembalikan rentang status gizi berdasarkan IMT untuk 6 kategori WHO
        // Penambahan/pengurangan 0.01 digunakan untuk memastikan pemisahan rentang yang jelas
        // dan menghindari tumpang tindih karena presisi floating point.
        return [
            'ranges' => [
                // Sangat Kurus: < -3 SD
                'red_sangat_kurus' => [$overall_min_imt, $min3SD - 0.01],
                // Kurus: >= -3 SD to < -2 SD
                'yellow_kurus'     => [$min3SD, $min2SD - 0.01],
                // Normal: >= -2 SD to <= +1 SD
                'green_normal'     => [$min2SD, $plus1SD + 0.01],
                // Berisiko Gizi Lebih: > +1 SD to <= +2 SD
                'blue_risiko'      => [$plus1SD + 0.01, $plus2SD + 0.01],
                // Gizi Lebih: > +2 SD to <= +3 SD
                'dark_blue_gizi_lebih' => [$plus2SD + 0.01, $plus3SD + 0.01],
                // Obesitas: > +3 SD
                'red_obesitas'     => [$plus3SD + 0.01, $overall_max_imt]
            ],
            'overall_min' => $overall_min_imt,
            'overall_max' => $overall_max_imt,
        ];
    }



}