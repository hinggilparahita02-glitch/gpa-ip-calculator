<?php
// konversi nilai angka ke huruf
function numericToLetter($score) {
    if ($score >= 90) return "A";
    if ($score >= 87) return "A-";
    if ($score >= 83) return "B+";
    if ($score >= 80) return "B";
    if ($score >= 77) return "B-";
    if ($score >= 73) return "C+";
    if ($score >= 70) return "C";
    if ($score >= 67) return "C-";
    if ($score >= 65) return "D";
    return "F";
}

// konversi huruf ke poin 4.0
function letterToPoint($letter) {
    switch ($letter) {
        case "A":  return 4.0;
        case "A-": return 3.7;
        case "B+": return 3.3;
        case "B":  return 3.0;
        case "B-": return 2.7;
        case "C+": return 2.3;
        case "C":  return 2.0;
        case "C-": return 1.7;
        case "D":  return 1.0;
        default:   return 0.0;
    }
}

// hitung GPA dari array courses
function calculateGPA($courses) {
    $totalCredits = 0;
    $totalQuality = 0;

    foreach ($courses as $c) {
        $totalCredits += $c['credits'];
        $totalQuality += $c['grade_point'] * $c['credits'];
    }

    if ($totalCredits == 0) return 0;
    return $totalQuality / $totalCredits; // rumus standar GPA. [web:14][web:20]
}

function getGPAStatus($gpa) {
    if ($gpa == 0) return "Belum ada data";
    if ($gpa >= 3.5) return "Sangat Baik";
    if ($gpa >= 3.0) return "Baik";
    if ($gpa >= 2.5) return "Cukup";
    if ($gpa >= 2.0) return "Perlu peningkatan";
    return "Kurang, segera evaluasi belajar";
}
