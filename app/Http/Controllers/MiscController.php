<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\FacultyScheduleMapping;
use App\Models\Scheduling;
use App\Models\TestConfig;
use App\Models\TestSubject;
use App\Models\Venue;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function venues($centre_id)
    {
        return Venue::where(['centre_id' => $centre_id])->get();
    }

    public function facultyMappings(Scheduling $scheduling)
    {
        $index = 0;
        $mapped_ids = [];
        $faculties = Faculty::all();
        $config_id = $scheduling->test_config_id;
        $mappings = FacultyScheduleMapping::where(['scheduling_id' => $scheduling->id])->get();
        foreach ($mappings as $mapping)
            $mapped_ids[] = $mapping->faculty_id;

        foreach ($faculties as $faculty) {
            if ($index < count($mappings))
                $faculty->mapped = in_array($faculty->id, $mapped_ids);
        }

        return view('pages.author.test.config.ajax.faculty-mappings', compact('faculties', 'config_id'));
    }

    public function batchCapacity(Venue $venue)
    {
        return $venue;
    }

    public function testConfig($year, $type, $code)
    {
        $configs = TestConfig::with(['test_type', 'test_code'])
            ->select(['id', 'session', 'semester', 'test_type_id', 'test_code_id'])
            ->orderBy('session', 'desc')
            ->where(['session' => $year, 'test_type_id' => $type, 'test_code_id' => $code])
            ->get();

        return view('pages.admin.reports.ajax.tests', compact('configs'));
    }

    public function testSubjects($config)
    {
        $subjects = TestSubject::with('subject')->select(['subject_id'])->where('test_config_id', $config)->get();

        return view('pages.admin.reports.ajax.subjects', compact('subjects'));
    }

    public function testCandidates($config)
    {
        $candidates = DB::table('presentations')
            ->join('candidates', 'candidates.id', '=', 'presentations.scheduled_candidate_id')
            ->select(['candidates.id', 'indexing', 'surname', 'firstname', 'other_names'])
            ->where('presentations.test_config_id', $config)
            ->distinct('candidates.id')
            ->get();

        return view('pages.admin.reports.ajax.candidates', compact('candidates'));
    }


    public function configuration(Request $request){
        // $output = array();

        // exec('ifconfig | grep en ', $output);
        // $ethernet_adapters = array_filter($output);
        // foreach ($ethernet_adapters as $key=> $adapter) {
        //     if (strpos($adapter, 'en') !== false) {
        //     echo trim($adapter) . "<br>";
        //     }
        // }
        // return;
        // return json_encode($ethernet_adapters, true);
        // // return array_filter(explode(':',json_encode($ethernet_adapters, true)));

        // exec('ip link | grep "eth" | cut -d ":" -f2', $output);
        // $ethernet_adapters = array_filter($output);

        // echo "Ethernet Adapters:<br>";
        // foreach ($ethernet_adapters as $adapter) {
        //     echo trim($adapter) . "<br>";
        // }
        // die(phpinfo());
        
        $method = $request->method();
        if($method == 'POST'){
            $network_interface = $request->network_interface;
            $ip_address = $request->ip_address;
            $gateway = $request->gateway;
            $net_port = $request->net_port;
            $dhcp = $request->dhcp;
            $file_name = $request->file_name;
            if($dhcp == 1){
                $netplan_config = [
                    'network' => [
                        'version' => 2,
                        'renderer' => 'networkd',
                        'ethernets' => [
                            $network_interface => [
                                'dhcp4' => true,
                            ]
                        ]
                    ]
                ];
            }else{
                $netplan_config = [
                    'network' => [
                        'version' => 2,
                        'renderer' => 'networkd',
                        'ethernets' => [
                            $network_interface => [
                                'dhcp4' => false,
                                'addresses' => [$ip_address],
                                'gateway4' => $gateway,
                                'nameservers' => [
                                    'addresses' => ['8.8.8.8', '8.8.4.4']
                                ]
                            ]
                        ]
                    ]
                ];
            }
            

            // return $netplan_config;
            
            yaml_emit_file('/etc/netplan/'.$file_name, $netplan_config, YAML_ANY_ENCODING, 4);
            // yaml_emit( $netplan_config, YAML_ANY_ENCODING, 4);
            return back()->with('success', 'Server configured successfully');
        }
        //second
        $output = array();
        $output1 = array();
        exec('ls /sys/class/net', $output);
        exec('ls /etc/netplan/', $output1);
        $network_interfaces = $output;
        $configuration_files = $output1;
        return view('pages.server.configuration',compact('network_interfaces', 'configuration_files'));






        // echo "Network Interfaces:<br>";
        // foreach ($network_interfaces as $interface) {
        //     if (strpos($interface, 'eth') !== false) {
        //         echo $interface . "<br>";
        //     }
        // }
        
        // //third
        // $output = shell_exec('nmcli device status | grep "ethernet"');
        // $ethernet_adapters = explode("\n", $output);

        // echo "Ethernet Adapters:<br>";
        // foreach ($ethernet_adapters as $adapter) {
        //     echo trim(explode(":", $adapter)[0]) . "<br>";
        // }
        
        // //forth
        // $network_interfaces = file('/proc/net/dev');
        // array_shift($network_interfaces); // Remove header
        // array_shift($network_interfaces); // Remove header

        // echo "Network Interfaces:<br>";
        // foreach ($network_interfaces as $interface) {
        //     $interface_info = explode(":", trim($interface));
        //     if (strpos($interface_info[0], 'eth') !== false) {
        //         echo $interface_info[0] . "<br>";
        //     }
        // }
    }

}
