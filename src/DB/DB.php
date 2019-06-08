<?php

namespace BNI;

/*
    Database Query Builder by BNI
    Open README.md to see how to use this thing
*/

class DB {
    public function checkWhereAvailable($query) {
        $p = explode("WHERE", $query);
        if(!$p[1]) {
            return false;
        }else {
            return true;
        }
    }
    public function tabel($namaTabel) {
        global $query;
        global $tabel;
        $tabel = $namaTabel;
        return new DB;
    }
    public function pilih($kolom = NULL) {
        global $query;
        global $tabel;
        if($kolom == "") {
            $kolom = "*";
        }
        $query = "SELECT $kolom FROM $tabel";
        return new DB;
    }
    public function innerJoin($tabel, $firstFK, $operator, $secondFK) {
        global $query;
        $query .= " INNER JOIN ".$tabel." ON $firstFK ".$operator." $secondFK";
        return new DB;
    }
    public function leftJoin($tabel, $firstFK, $operator, $secondFK) {
        global $query;
        $query .= " LEFT JOIN ".$tabel." ON $firstFK ".$operator." $secondFK";
        return new DB;
    }
    public function rightJoin($tabel, $firstFK, $operator, $secondFK) {
        global $query;
        $query .= " RIGHT JOIN ".$tabel." ON $firstFK ".$operator." $secondFK";
        return new DB;
    }

    public function hapus() {
        global $query;
        global $tabel;
        $query  = "DELETE FROM $tabel";
        return new DB;
    }

    public function ubah($data) {
        global $query;
        global $tabel;
        $query = "UPDATE $tabel SET ";
        $i = 0;
        foreach($data as $key => $value) {
            if($i++ < count($data) - 1) {
                $separator = ", ";
            }else {
                $separator = "";
            }
            $query .= "$key = '$value'" . $separator;
        }
        return new DB;
    }

    public function tambah($data) {
        global $query;
        global $tabel;

        $query = "INSERT INTO $tabel (";
        $i = 0;
        foreach($data as $key => $value) {
            $separator = ($i++ < count($data) - 1) ? ", " : "";
            $query .= "'$key'" . $separator;
        }
        $query .= ") VALUES (";

        $a = 0;
        foreach($data as $key => $value) {
            $separator = ($a++ < count($data) - 1) ? ", " : "";
            $query .= "'$value'" . $separator;
        }
        $query .= ")";

        return new DB;
    }

    public function dimana($filter, $operator = NULL, $value = NULL) {
        global $query;
        $adaWhere = $this->checkWhereAvailable($query);
        if($adaWhere) {
            $query .= " AND";
        }else {
            $query .= " WHERE ";
        }
        
        if(is_array($filter)) {
            $i = 0;
            $totalFilter = count($filter);
            foreach ($filter as $key => $value) {
                if($i++ < $totalFilter - 1) {
                    $separator = " AND ";
                }else {
                    $separator = "";
                }
                $query .= $value[0] . " " . $value[1] . " '" . $value[2] . "'" . $separator;
            }
        }else {
            $query .= " $filter $operator '$value'";
        }
        return new DB;
    }
    public function antara($kolom, $value) {
        global $query;
        $adaWhere = $this->checkWhereAvailable($query);
        if($adaWhere) {
            $query .= " AND $kolom BETWEEN '$value[0]' AND '$value[1]'";
        }else {
            $query .= " WHERE $kolom BETWEEN '$value[0]' AND '$value[1]'";
        }
        return new DB;
    }
    public function batasi($posisi, $batas = NULL) {
        global $query;
        if($batas == "") {
            $batas = $posisi;
            $query .= " LIMIT $batas";
        }else {
            $query .= " LIMIT $posisi,$batas";
        }
        return new DB;
    }
    public function urutkan($kolom, $mode = NULL) {
        global $query;
        
        if(is_array($kolom)) {
            $query .= " ORDER BY ";
            $i = 0;
            $totalFilter = count($kolom);
            foreach ($kolom as $row) {
                $separator = ($i++ < $totalFilter - 1) ? ", " : "";
                $query .= "$row[0] $row[1]".$separator;
            }
        }else {
            $query .= " ORDER BY $kolom $mode";
        }
        return new DB;
    }

    public function jalankan() {
        global $query;
        return $query;
    }
}