<?php

namespace App\Controllers;

use App\Models\CompanySearch;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SearchCompanyController
{
    private $companyModel;

    public function __construct()
    {
        $this->companyModel = new CompanySearch();
    }

    public function searchCompany(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Mengambil parameter 'name' dari query
        $queryParams = $request->getQueryParams();
        $company_name = $queryParams['name'] ?? '';

        // Memanggil metode untuk mendapatkan perusahaan berdasarkan na
        $company = $this->companyModel->getCompanyByName($company_name);

        // Mengatur header untuk respons JSON
        $response = $response->withHeader('Content-Type', 'application/json');

        // Mengonversi hasil pencarian ke JSON dan menulis ke body respon
        $response->getBody()->write(json_encode($company));

        return $response;
    }
}
