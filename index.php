<?php
// 强制返回JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// 获取用户真实公网IP
function getRealIp() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// IP转数字
function ipToNumber($ip) {
    return sprintf("%u", ip2long($ip));
}

// 【核心】国内省份IP段库（覆盖大陆所有省/直辖市/自治区）
function getIpProvince($ip) {
    $ipNum = ipToNumber($ip);
    $ipRules = [
        // 北京
        ['min' => ipToNumber('36.112.0.0'), 'max' => ipToNumber('36.119.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('106.38.0.0'), 'max' => ipToNumber('106.39.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('111.202.0.0'), 'max' => ipToNumber('111.203.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('114.247.0.0'), 'max' => ipToNumber('114.251.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('120.55.0.0'), 'max' => ipToNumber('120.55.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('123.112.0.0'), 'max' => ipToNumber('123.125.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('124.64.0.0'), 'max' => ipToNumber('124.65.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('124.126.0.0'), 'max' => ipToNumber('124.127.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('140.206.0.0'), 'max' => ipToNumber('140.207.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('144.0.0.0'), 'max' => ipToNumber('144.255.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('153.0.0.0'), 'max' => ipToNumber('153.3.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('153.34.0.0'), 'max' => ipToNumber('153.35.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('153.118.0.0'), 'max' => ipToNumber('153.119.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('162.105.0.0'), 'max' => ipToNumber('162.105.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('180.149.0.0'), 'max' => ipToNumber('180.149.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('202.106.0.0'), 'max' => ipToNumber('202.108.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('210.72.0.0'), 'max' => ipToNumber('210.75.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('211.71.0.0'), 'max' => ipToNumber('211.71.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('218.240.0.0'), 'max' => ipToNumber('218.247.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('219.141.0.0'), 'max' => ipToNumber('219.143.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('220.181.0.0'), 'max' => ipToNumber('220.181.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('221.216.0.0'), 'max' => ipToNumber('221.223.255.255'), 'prov' => '北京'],
        ['min' => ipToNumber('222.128.0.0'), 'max' => ipToNumber('222.131.255.255'), 'prov' => '北京'],

        // 上海
        ['min' => ipToNumber('101.80.0.0'), 'max' => ipToNumber('101.95.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('103.22.128.0'), 'max' => ipToNumber('103.22.159.255'), 'prov' => '上海'],
        ['min' => ipToNumber('112.64.0.0'), 'max' => ipToNumber('112.71.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('114.80.0.0'), 'max' => ipToNumber('114.95.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('116.228.0.0'), 'max' => ipToNumber('116.231.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('117.136.0.0'), 'max' => ipToNumber('117.143.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('124.74.0.0'), 'max' => ipToNumber('124.77.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('180.163.0.0'), 'max' => ipToNumber('180.166.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('183.192.0.0'), 'max' => ipToNumber('183.199.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('202.120.0.0'), 'max' => ipToNumber('202.121.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('210.22.0.0'), 'max' => ipToNumber('210.23.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('211.95.0.0'), 'max' => ipToNumber('211.99.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('218.1.0.0'), 'max' => ipToNumber('218.3.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('218.78.0.0'), 'max' => ipToNumber('218.79.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('220.194.0.0'), 'max' => ipToNumber('220.197.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('222.73.0.0'), 'max' => ipToNumber('222.73.255.255'), 'prov' => '上海'],
        ['min' => ipToNumber('223.112.0.0'), 'max' => ipToNumber('223.113.255.255'), 'prov' => '上海'],

        // 天津
        ['min' => ipToNumber('103.23.128.0'), 'max' => ipToNumber('103.23.143.255'), 'prov' => '天津'],
        ['min' => ipToNumber('111.161.0.0'), 'max' => ipToNumber('111.161.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('117.8.0.0'), 'max' => ipToNumber('117.15.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('120.66.0.0'), 'max' => ipToNumber('120.71.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('123.150.0.0'), 'max' => ipToNumber('123.151.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('125.39.0.0'), 'max' => ipToNumber('125.39.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('202.99.64.0'), 'max' => ipToNumber('202.99.95.255'), 'prov' => '天津'],
        ['min' => ipToNumber('211.103.0.0'), 'max' => ipToNumber('211.103.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('218.68.0.0'), 'max' => ipToNumber('218.69.255.255'), 'prov' => '天津'],
        ['min' => ipToNumber('221.196.0.0'), 'max' => ipToNumber('221.199.255.255'), 'prov' => '天津'],

        // 重庆
        ['min' => ipToNumber('106.80.0.0'), 'max' => ipToNumber('106.95.255.255'), 'prov' => '重庆'],
        ['min' => ipToNumber('113.204.0.0'), 'max' => ipToNumber('113.207.255.255'), 'prov' => '重庆'],
        ['min' => ipToNumber('125.82.0.0'), 'max' => ipToNumber('125.83.255.255'), 'prov' => '重庆'],
        ['min' => ipToNumber('183.64.0.0'), 'max' => ipToNumber('183.71.255.255'), 'prov' => '重庆'],
        ['min' => ipToNumber('218.70.0.0'), 'max' => ipToNumber('218.71.255.255'), 'prov' => '重庆'],
        ['min' => ipToNumber('222.177.0.0'), 'max' => ipToNumber('222.179.255.255'), 'prov' => '重庆'],

        // 广东
        ['min' => ipToNumber('14.134.0.0'), 'max' => ipToNumber('14.135.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('14.152.0.0'), 'max' => ipToNumber('14.153.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('14.208.0.0'), 'max' => ipToNumber('14.209.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('112.90.0.0'), 'max' => ipToNumber('112.95.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('113.64.0.0'), 'max' => ipToNumber('113.111.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('116.16.0.0'), 'max' => ipToNumber('116.31.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('119.128.0.0'), 'max' => ipToNumber('119.143.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('120.229.0.0'), 'max' => ipToNumber('120.230.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('121.8.0.0'), 'max' => ipToNumber('121.15.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('183.56.0.0'), 'max' => ipToNumber('183.63.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('202.105.0.0'), 'max' => ipToNumber('202.105.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('210.76.0.0'), 'max' => ipToNumber('210.79.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('218.18.0.0'), 'max' => ipToNumber('218.19.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('219.137.0.0'), 'max' => ipToNumber('219.138.255.255'), 'prov' => '广东'],
        ['min' => ipToNumber('220.231.0.0'), 'max' => ipToNumber('220.231.255.255'), 'prov' => '广东'],

        // 江苏
        ['min' => ipToNumber('112.1.0.0'), 'max' => ipToNumber('112.3.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('114.212.0.0'), 'max' => ipToNumber('114.231.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('117.80.0.0'), 'max' => ipToNumber('117.87.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('120.192.0.0'), 'max' => ipToNumber('120.199.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('121.224.0.0'), 'max' => ipToNumber('121.247.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('122.192.0.0'), 'max' => ipToNumber('122.199.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('180.101.0.0'), 'max' => ipToNumber('180.111.255.255'), 'prov' => '江苏'],
        ['min' => ipToNumber('221.224.0.0'), 'max' => ipToNumber('221.231.255.255'), 'prov' => '江苏'],

        // 浙江
        ['min' => ipToNumber('112.16.0.0'), 'max' => ipToNumber('112.23.255.255'), 'prov' => '浙江'],
        ['min' => ipToNumber('115.192.0.0'), 'max' => ipToNumber('115.223.255.255'), 'prov' => '浙江'],
        ['min' => ipToNumber('122.224.0.0'), 'max' => ipToNumber('122.239.255.255'), 'prov' => '浙江'],
        ['min' => ipToNumber('183.128.0.0'), 'max' => ipToNumber('183.159.255.255'), 'prov' => '浙江'],
        ['min' => ipToNumber('202.91.0.0'), 'max' => ipToNumber('202.93.255.255'), 'prov' => '浙江'],
        ['min' => ipToNumber('220.184.0.0'), 'max' => ipToNumber('220.191.255.255'), 'prov' => '浙江'],

        // 山东
        ['min' => ipToNumber('112.224.0.0'), 'max' => ipToNumber('112.239.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('113.120.0.0'), 'max' => ipToNumber('113.127.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('119.164.0.0'), 'max' => ipToNumber('119.171.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('120.192.0.0'), 'max' => ipToNumber('120.199.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('123.128.0.0'), 'max' => ipToNumber('123.135.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('124.128.0.0'), 'max' => ipToNumber('124.135.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('202.102.0.0'), 'max' => ipToNumber('202.104.255.255'), 'prov' => '山东'],
        ['min' => ipToNumber('218.56.0.0'), 'max' => ipToNumber('218.59.255.255'), 'prov' => '山东'],

        // 四川
        ['min' => ipToNumber('103.208.0.0'), 'max' => ipToNumber('103.223.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('110.184.0.0'), 'max' => ipToNumber('110.191.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('118.112.0.0'), 'max' => ipToNumber('118.127.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('125.64.0.0'), 'max' => ipToNumber('125.71.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('139.207.0.0'), 'max' => ipToNumber('139.208.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('171.208.0.0'), 'max' => ipToNumber('171.215.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('182.128.0.0'), 'max' => ipToNumber('182.143.255.255'), 'prov' => '四川'],
        ['min' => ipToNumber('218.88.0.0'), 'max' => ipToNumber('218.95.255.255'), 'prov' => '四川'],

        // 河北
        ['min' => ipToNumber('106.110.0.0'), 'max' => ipToNumber('106.111.255.255'), 'prov' => '河北'],
        ['min' => ipToNumber('110.249.0.0'), 'max' => ipToNumber('110.255.255.255'), 'prov' => '河北'],
        ['min' => ipToNumber('111.224.0.0'), 'max' => ipToNumber('111.231.255.255'), 'prov' => '河北'],
        ['min' => ipToNumber('120.80.0.0'), 'max' => ipToNumber('120.87.255.255'), 'prov' => '河北'],
        ['min' => ipToNumber('121.17.0.0'), 'max' => ipToNumber('121.23.255.255'), 'prov' => '河北'],
        ['min' => ipToNumber('123.180.0.0'), 'max' => ipToNumber('123.183.255.255'), 'prov' => '河北'],
        ['min' => ipToNumber('221.192.0.0'), 'max' => ipToNumber('221.195.255.255'), 'prov' => '河北'],

        // 河南
        ['min' => ipToNumber('1.192.0.0'), 'max' => ipToNumber('1.207.255.255'), 'prov' => '河南'],
        ['min' => ipToNumber('111.64.0.0'), 'max' => ipToNumber('111.71.255.255'), 'prov' => '河南'],
        ['min' => ipToNumber('115.48.0.0'), 'max' => ipToNumber('115.63.255.255'), 'prov' => '河南'],
        ['min' => ipToNumber('123.148.0.0'), 'max' => ipToNumber('123.159.255.255'), 'prov' => '河南'],
        ['min' => ipToNumber('125.40.0.0'), 'max' => ipToNumber('125.47.255.255'), 'prov' => '河南'],
        ['min' => ipToNumber('222.88.0.0'), 'max' => ipToNumber('222.95.255.255'), 'prov' => '河南'],

        // 辽宁
        ['min' => ipToNumber('113.32.0.0'), 'max' => ipToNumber('113.47.255.255'), 'prov' => '辽宁'],
        ['min' => ipToNumber('119.113.0.0'), 'max' => ipToNumber('119.127.255.255'), 'prov' => '辽宁'],
        ['min' => ipToNumber('123.188.0.0'), 'max' => ipToNumber('123.191.255.255'), 'prov' => '辽宁'],
        ['min' => ipToNumber('175.168.0.0'), 'max' => ipToNumber('175.175.255.255'), 'prov' => '辽宁'],
        ['min' => ipToNumber('218.24.0.0'), 'max' => ipToNumber('218.25.255.255'), 'prov' => '辽宁'],

        // 黑龙江
        ['min' => ipToNumber('1.184.0.0'), 'max' => ipToNumber('1.191.255.255'), 'prov' => '黑龙江'],
        ['min' => ipToNumber('111.40.0.0'), 'max' => ipToNumber('111.47.255.255'), 'prov' => '黑龙江'],
        ['min' => ipToNumber('120.192.0.0'), 'max' => ipToNumber('120.199.255.255'), 'prov' => '黑龙江'],
        ['min' => ipToNumber('124.160.0.0'), 'max' => ipToNumber('124.167.255.255'), 'prov' => '黑龙江'],
        ['min' => ipToNumber('221.208.0.0'), 'max' => ipToNumber('221.215.255.255'), 'prov' => '黑龙江'],

        // 吉林
        ['min' => ipToNumber('119.48.0.0'), 'max' => ipToNumber('119.55.255.255'), 'prov' => '吉林'],
        ['min' => ipToNumber('122.136.0.0'), 'max' => ipToNumber('122.143.255.255'), 'prov' => '吉林'],
        ['min' => ipToNumber('124.234.0.0'), 'max' => ipToNumber('124.239.255.255'), 'prov' => '吉林'],
        ['min' => ipToNumber('175.168.0.0'), 'max' => ipToNumber('175.175.255.255'), 'prov' => '吉林'],

        // 湖南
        ['min' => ipToNumber('110.72.0.0'), 'max' => ipToNumber('110.79.255.255'), 'prov' => '湖南'],
        ['min' => ipToNumber('113.232.0.0'), 'max' => ipToNumber('113.247.255.255'), 'prov' => '湖南'],
        ['min' => ipToNumber('119.32.0.0'), 'max' => ipToNumber('119.39.255.255'), 'prov' => '湖南'],
        ['min' => ipToNumber('220.168.0.0'), 'max' => ipToNumber('220.175.255.255'), 'prov' => '湖南'],

        // 湖北
        ['min' => ipToNumber('111.172.0.0'), 'max' => ipToNumber('111.179.255.255'), 'prov' => '湖北'],
        ['min' => ipToNumber('113.56.0.0'), 'max' => ipToNumber('113.63.255.255'), 'prov' => '湖北'],
        ['min' => ipToNumber('117.156.0.0'), 'max' => ipToNumber('117.159.255.255'), 'prov' => '湖北'],
        ['min' => ipToNumber('119.96.0.0'), 'max' => ipToNumber('119.103.255.255'), 'prov' => '湖北'],
        ['min' => ipToNumber('221.232.0.0'), 'max' => ipToNumber('221.239.255.255'), 'prov' => '湖北'],

        // 福建
        ['min' => ipToNumber('110.88.0.0'), 'max' => ipToNumber('110.95.255.255'), 'prov' => '福建'],
        ['min' => ipToNumber('117.24.0.0'), 'max' => ipToNumber('117.31.255.255'), 'prov' => '福建'],
        ['min' => ipToNumber('120.32.0.0'), 'max' => ipToNumber('120.47.255.255'), 'prov' => '福建'],
        ['min' => ipToNumber('218.5.0.0'), 'max' => ipToNumber('218.15.255.255'), 'prov' => '福建'],

        // 安徽
        ['min' => ipToNumber('112.28.0.0'), 'max' => ipToNumber('112.31.255.255'), 'prov' => '安徽'],
        ['min' => ipToNumber('114.104.0.0'), 'max' => ipToNumber('114.111.255.255'), 'prov' => '安徽'],
        ['min' => ipToNumber('121.60.0.0'), 'max' => ipToNumber('121.63.255.255'), 'prov' => '安徽'],
        ['min' => ipToNumber('223.240.0.0'), 'max' => ipToNumber('223.247.255.255'), 'prov' => '安徽'],

        // 江西
        ['min' => ipToNumber('111.72.0.0'), 'max' => ipToNumber('111.79.255.255'), 'prov' => '江西'],
        ['min' => ipToNumber('115.148.0.0'), 'max' => ipToNumber('115.159.255.255'), 'prov' => '江西'],
        ['min' => ipToNumber('182.88.0.0'), 'max' => ipToNumber('182.95.255.255'), 'prov' => '江西'],
        ['min' => ipToNumber('218.64.0.0'), 'max' => ipToNumber('218.67.255.255'), 'prov' => '江西'],

        // 陕西
        ['min' => ipToNumber('1.80.0.0'), 'max' => ipToNumber('1.95.255.255'), 'prov' => '陕西'],
        ['min' => ipToNumber('113.140.0.0'), 'max' => ipToNumber('113.143.255.255'), 'prov' => '陕西'],
        ['min' => ipToNumber('117.32.0.0'), 'max' => ipToNumber('117.39.255.255'), 'prov' => '陕西'],
        ['min' => ipToNumber('124.88.0.0'), 'max' => ipToNumber('124.95.255.255'), 'prov' => '陕西'],
        ['min' => ipToNumber('219.144.0.0'), 'max' => ipToNumber('219.145.255.255'), 'prov' => '陕西'],

        // 山西
        ['min' => ipToNumber('1.120.0.0'), 'max' => ipToNumber('1.127.255.255'), 'prov' => '山西'],
        ['min' => ipToNumber('110.176.0.0'), 'max' => ipToNumber('110.183.255.255'), 'prov' => '山西'],
        ['min' => ipToNumber('123.172.0.0'), 'max' => ipToNumber('123.179.255.255'), 'prov' => '山西'],
        ['min' => ipToNumber('220.178.0.0'), 'max' => ipToNumber('220.180.255.255'), 'prov' => '山西'],

        // 云南
        ['min' => ipToNumber('106.56.0.0'), 'max' => ipToNumber('106.63.255.255'), 'prov' => '云南'],
        ['min' => ipToNumber('112.112.0.0'), 'max' => ipToNumber('112.119.255.255'), 'prov' => '云南'],
        ['min' => ipToNumber('116.240.0.0'), 'max' => ipToNumber('116.247.255.255'), 'prov' => '云南'],
        ['min' => ipToNumber('183.224.0.0'), 'max' => ipToNumber('183.231.255.255'), 'prov' => '云南'],

        // 贵州
        ['min' => ipToNumber('1.112.0.0'), 'max' => ipToNumber('1.119.255.255'), 'prov' => '贵州'],
        ['min' => ipToNumber('111.80.0.0'), 'max' => ipToNumber('111.87.255.255'), 'prov' => '贵州'],
        ['min' => ipToNumber('124.156.0.0'), 'max' => ipToNumber('124.159.255.255'), 'prov' => '贵州'],
        ['min' => ipToNumber('222.80.0.0'), 'max' => ipToNumber('222.87.255.255'), 'prov' => '贵州'],

        // 广西
        ['min' => ipToNumber('103.200.0.0'), 'max' => ipToNumber('103.207.255.255'), 'prov' => '广西'],
        ['min' => ipToNumber('113.16.0.0'), 'max' => ipToNumber('113.23.255.255'), 'prov' => '广西'],
        ['min' => ipToNumber('121.31.0.0'), 'max' => ipToNumber('121.38.255.255'), 'prov' => '广西'],
        ['min' => ipToNumber('222.216.0.0'), 'max' => ipToNumber('222.223.255.255'), 'prov' => '广西'],

        // 海南
        ['min' => ipToNumber('112.200.0.0'), 'max' => ipToNumber('112.207.255.255'), 'prov' => '海南'],
        ['min' => ipToNumber('218.77.0.0'), 'max' => ipToNumber('218.77.255.255'), 'prov' => '海南'],

        // 甘肃
        ['min' => ipToNumber('1.48.0.0'), 'max' => ipToNumber('1.63.255.255'), 'prov' => '甘肃'],
        ['min' => ipToNumber('118.180.0.0'), 'max' => ipToNumber('118.183.255.255'), 'prov' => '甘肃'],
        ['min' => ipToNumber('125.72.0.0'), 'max' => ipToNumber('125.79.255.255'), 'prov' => '甘肃'],

        // 宁夏
        ['min' => ipToNumber('1.32.0.0'), 'max' => ipToNumber('1.47.255.255'), 'prov' => '宁夏'],
        ['min' => ipToNumber('124.152.0.0'), 'max' => ipToNumber('124.155.255.255'), 'prov' => '宁夏'],

        // 青海
        ['min' => ipToNumber('1.24.0.0'), 'max' => ipToNumber('1.31.255.255'), 'prov' => '青海'],
        ['min' => ipToNumber('118.212.0.0'), 'max' => ipToNumber('118.215.255.255'), 'prov' => '青海'],

        // 内蒙古
        ['min' => ipToNumber('1.96.0.0'), 'max' => ipToNumber('1.111.255.255'), 'prov' => '内蒙古'],
        ['min' => ipToNumber('110.16.0.0'), 'max' => ipToNumber('110.23.255.255'), 'prov' => '内蒙古'],
        ['min' => ipToNumber('124.168.0.0'), 'max' => ipToNumber('124.175.255.255'), 'prov' => '内蒙古'],

        // 新疆
        ['min' => ipToNumber('1.12.0.0'), 'max' => ipToNumber('1.23.255.255'), 'prov' => '新疆'],
        ['min' => ipToNumber('110.156.0.0'), 'max' => ipToNumber('110.159.255.255'), 'prov' => '新疆'],
        ['min' => ipToNumber('124.112.0.0'), 'max' => ipToNumber('124.119.255.255'), 'prov' => '新疆'],

        // 西藏
        ['min' => ipToNumber('1.4.0.0'), 'max' => ipToNumber('1.11.255.255'), 'prov' => '西藏'],
        ['min' => ipToNumber('111.12.0.0'), 'max' => ipToNumber('111.15.255.255'), 'prov' => '西藏'],
    ];

    foreach ($ipRules as $rule) {
        if ($ipNum >= $rule['min'] && $ipNum <= $rule['max']) {
            return $rule['prov'];
        }
    }
    return '未知';
}

// 主逻辑
$userIp = getRealIp();
$province = getIpProvince($userIp);

// 输出API JSON
echo json_encode([
    'code' => 0,
    'msg' => 'success',
    'data' => [
        'ip' => $userIp,
        'province' => $province
    ]
], JSON_UNESCAPED_UNICODE);
?>
