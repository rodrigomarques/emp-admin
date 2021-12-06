<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategoria;
use App\Models\Usuario;
use App\Models\Endereco;
use App\Models\Associado;

use App\Services\AssociadoService;
class AssociadoController extends Controller
{
    public function passo1(){
        $data = [];
        $data["listSubCategoria"] = SubCategoria::all();
        return view("associado/passo1", $data);
    }

    public function passo1Save(Request $request){
        $service = new AssociadoService();
        try{
            $response = $service->salvarPasso1($request);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                $entity = $response->getEntity();
                $associado = $entity["associado"];
                $idAssociado = base64_encode($associado->id);
                return redirect()->route('associado.passo2', [ 'idassociado' => $idAssociado]);
            }

        }catch(\Exception $e){
            session()->flash('error', "Não pode salvar o associado");
        }
        return back()
            ->withInput();
    }

    public function passo2($idassociado){
        $data = [];
        $data["idassociado"] = $idassociado;
        return view("associado/passo2", $data);
    }

    public function passo2Save($idassociado, Request $request){
        $service = new AssociadoService();
        try{

            $paramIdAssociado = base64_decode($idassociado);
            $endereco = new Endereco($request->all());
            $response = $service->salvarPasso2($endereco, $paramIdAssociado);
            if($response->getStatus() === 400)
                return back()->withErrors($response->getErrors())
                    ->withInput();

            if($response->getStatus() === 200){
                return redirect()->route('associado.passo3', [ 'idassociado' => $idassociado]);
            }

        }catch(\Exception $e){
            session()->flash('error', "Não pode salvar o endereço");
        }
        return back()
            ->withInput();
    }

    public function passo3($idassociado){
        $data = [];
        $data["idassociado"] = $idassociado;
        return view("associado/passo3", $data);
    }

    public function passo3Save($idassociado, Request $request) {
        $service = new AssociadoService();
        try {
            $paramIdAssociado = base64_decode($idassociado);
            $response = $service->salvarPasso3($request, $paramIdAssociado);
            if ($response->getStatus() === 400) {
                return back()->withErrors($response->getErrors())
                    ->withInput();
            }

            if ($response->getStatus() === 200) {
                session()->flash('success', "Dependente salvo com sucesso!");
                return back();
            }

        } catch (\Exception $e) {
            session()->flash('error', "Não pode salvar o dependente");
        }
        return back()
            ->withInput();

    }

    public function passo4($idassociado){
        $data = [];
        $service = new AssociadoService();
        try {
            $paramIdAssociado = base64_decode($idassociado);
            $response = $service->salvarPasso4($paramIdAssociado);
            if ($response->getStatus() === 400) {
                return back()->withErrors($response->getErrors())
                    ->withInput();
            }

            if ($response->getStatus() === 200) {
                return view("associado/passo4", $data);
            }

        } catch (\Exception $e) {
            session()->flash('error', "Não pode salvar o dependente");
        }
        session()->flash('error', "Associado não pode ser sucesso!");
        return back();
    }
}
