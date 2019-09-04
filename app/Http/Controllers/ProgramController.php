<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramMap;
use App\ProgramTrack;
use App\ProgramConcentration;
use App\EnterpriseProgram;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return Program::orderBy('bu', 'asc')
            ->orderBy('code', 'asc')
            ->with('requirements')
            ->with('enterprise')
            ->get();
    }

    public function store()
    {
        $program = $this->validateProgram();
        $stored = Program::create($program);
        return $stored;
    }

    public function update(Program $program)
    {
        $program->update($this->validateProgram());
        return $program;   
    }

    // Program code mapping between data sources
    public function maps()
    {
        $maps = ProgramMap::all();
        return $maps;
    }

    public function storeMap(Request $request)
    {
        $map = new ProgramMap;

        $map->code = $request->program;
        $map->mosaic = $request->program;
        $map->laurus = $request->map;

        $save = $map->save();

        return json_encode($save);
    }

    public function deleteMap(Request $request)
    {
        $code = $request->code;
        $laurus = $request->map;
        $delete = ProgramMap::where('code', $code)
            ->where('laurus', $laurus)
            ->delete();

        return json_encode($delete);
    }

    // Program Tracks
    public function storeTrack(Request $request)
    {
        $action = $request->action;

        $array['program'] = $request->program;
        $array['track'] = $request->track;

        if ($action == 'delete') {
            $del = ProgramTrack::where('program', $array['program'])
                ->where('track', $array['track'])
                ->delete();
            return $del;
        } else {
            $test = ProgramTrack::where('program', $array['program'])
                ->where('track', $array['track'])
                ->first();
            if (is_null($test)) {
                $post = ProgramTrack::insert($array);
            }
            return json_encode($post);
        }
    }

    // Program Concentrations
    public function storeConcentration(Request $request)
    {
        $action = $request->action;

        $array['program'] = $request->program;
        $array['concentration'] = $request->concentration;

        if ($action == 'delete') {
            $del = ProgramConcentration::where('program', $array['program'])
                ->where('concentration', $array['concentration'])
                ->delete();
            return $del;
        } else {
            $test = ProgramConcentration::where('program', $array['program'])
                ->where('concentration', $array['concentration'])
                ->first();
            if (is_null($test)) {
                $post = ProgramConcentration::insert($array);
            }
            return json_encode($post);
        }
    }

    // Enterprise attributes
    public function indexEnterprise()
    {
        return EnterpriseProgram::all();
    }
    public function showEnterprise($program_id)
    {
        return EnterpriseProgram::where('program_id', $program_id)->first();
    }
    public function storeEnterprise()
    {
        $data = $this->validateEnterprise();

        $check['program_id'] = $data['program_id'];
        $enterprise = EnterpriseProgram::updateOrCreate($check, $data);

        return $enterprise;
    }

    
    public function validateProgram()
    {
        return request()->validate([
            'id' => '',
            'code' => 'required',
            'active' => '',
            'name' => '',
            'full_name' => '',
            'partner' => '',
            'strategy' => '',
            'ltv' => '',
            'bu' => '',
            'location' => '',
            'vertical' => '',
            'subvertical' => '',
            'type' => '',
            'priority' => '',
            'concentrations' => '',
            'tracks' => '',
            'accreditation' => '',
            'online_percent' => '',
            'start_year' => '',
            'start_month' => '',
            'entry_points' => '',
            'renewal_date' => '',
        ]);
    }

    public function validateEnterprise()
    {
        return request()->validate([
            'id' => '',
            'program_id' => '',
            'program' => '',
            'pod' => '',
            'college' => '',
            'quadrant' => '',
        ]);
    }
}
