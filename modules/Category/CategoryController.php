<?php

namespace Module\Category;

use App\Core\Flash;
use App\Core\Request;
use App\Core\Validation;
use App\Core\View;
use App\Helpers\URL;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = $this->database
            ->query("SELECT * FROM categories ORDER BY created_at DESC")
            ->get();

        echo View::view("categories/index", [
            'title' => 'Kategori',
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        $errors = [];

        if ($request->isPost()) {
            $validation = new Validation($request);

            $validation
                ->required('nama', [
                    'custom_key' => 'Nama'
                ])
                ->unique('nama', 'categories', [
                    'custom_key' => 'Nama'
                ]);

            if ($validation->isValid()) {
                $success = $this->database
                    ->query("INSERT INTO categories VALUES (:id, :nama, :created_at)")
                    ->bind(':id', null)
                    ->bind(':nama', $request->post('nama'))
                    ->bind(':created_at', date('Y-m-d H:i:s'))
                    ->execute();

                Flash::set('success', 'Tersimpan!');

                if ($success) return URL::redirect(URL::path('/categories'));
            }

            $errors = $validation->getErrors();
        }

        echo View::view("categories/create", [
            'title' => 'Buat Kategori Baru',
            'errors' => $errors
        ]);
    }

    public function edit(Request $request)
    {
        $errors = [];
        $id = $request->getAllParams()[0];
        $category = $this->database
            ->query("SELECT * FROM categories WHERE id=:id LIMIT 1")
            ->bind(':id', $id)
            ->first();

        if ($request->isPost()) {
            $validation = new Validation($request);

            $validation
                ->required('nama', [
                    'custom_key' => 'Nama'
                ])
                ->unique('nama', 'categories', [
                    'custom_key' => 'Nama',
                    'when' => $category['nama'] !== $request->post('nama')
                ]);

            if ($validation->isValid()) {
                $success = $this->database
                    ->query("UPDATE categories SET nama=:nama WHERE id=:id")
                    ->bind(':id', $id)
                    ->bind(':nama', $request->post('nama'))
                    ->execute();

                Flash::set('success', 'Tersimpan!');

                if ($success) return URL::redirect(URL::path('/categories'));
            }

            $errors = $validation->getErrors();
        }

        echo View::view("categories/edit", [
            'title' => 'Edit Data Kategori',
            'errors' => $errors,
            'category' => $category
        ]);
    }

    public function delete(Request $request)
    {
        $id = $request->getAllParams()[0];

        $success = $this->database
            ->query("DELETE FROM categories WHERE id=:id")
            ->bind(':id', $id)
            ->execute();

        Flash::set('success', 'Terhapus!');

        if ($success) return URL::redirect(URL::path('/categories'));
    }
}
