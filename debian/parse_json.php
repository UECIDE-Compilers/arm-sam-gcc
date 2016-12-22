#!/usr/bin/env php
<?php

$opt = getopt("i:p:P:T:v:k:h:");

$data = file_get_contents($opt['i']);

$json = json_decode($data, false);

foreach ($json->packages as $id=>$data) {
    if ($data->name == $opt['p']) {

        if (array_key_exists('P', $opt)) {
            foreach ($data->platforms as $id=>$package) {
                if ($package->name == $opt['P']) {
                    if ($package->version == $opt['v']) {
                        print $package->{$opt['k']} . "\n";
                        exit(0);
                    }
                }
            }
        } else if (array_key_exists('T', $opt)) {
            foreach ($data->tools as $id=>$package) {
                if ($package->name == $opt['T']) {
                    if ($package->version == $opt['v']) {
                        if (array_key_exists('h', $opt)) {
                            foreach ($package->systems as $id=>$sys) {
                                if ($sys->host == $opt['h']) {
                                    print $sys->{$opt['k']} . "\n";
                                    exit(0);
                                }
                            }
                        } else {
                            print $package->{$opt['k']} . "\n";
                            exit(0);
                        }
                    }
                }
            }
        }
    }
}
