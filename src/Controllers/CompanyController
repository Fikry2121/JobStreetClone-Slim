<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Company;

class CompanyController
{
    public function getAllCompanies(Request $request, Response $response)
    {
        $companies = Company::getAllCompanies();

        if ($companies) {
            $response->getBody()->write(json_encode($companies));
        } else {
            $response->getBody()->write(json_encode(['message' => 'No companies found']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }


    public function getCompanyById(Request $request, Response $response, $args)
    {
        $id_company = $args['id_company'];
        $company = Company::getCompanyById($id_company);

        if ($company) {
            $response->getBody()->write(json_encode($company));
        } else {
            $response->getBody()->write(json_encode(['message' => 'Company not found']));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}