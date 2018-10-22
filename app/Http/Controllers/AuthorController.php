<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * @apiDefine AuthorNotFoundError
     *
     * @apiError AuthorNotFoundError The id of the Author was not found.
     *
     * @apiErrorExample Not Found Error:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "AuthorNotFoundError"
     *     }
     */

     /**
      * @apiDefine MethodNotAllowedError
      *
      * @apiError MethodNotAllowedError Method Not Allowed
      *
      * @apiErrorExample Method not Allowed:
      *     HTTP/1.1 405 Method not Allowed
      *     {
      *       "error": "MethodNotAllowedError"
      *     }
      */

     /**
      * @apiDefine ForbiddenAccessError
      *
      * @apiError ForbiddenAccessError You are not authorized to access this page
      *
      * @apiErrorExample Forbidden Access:
      *     HTTP/1.1 403 Forbidden
      *     {
      *       "error": "ForbiddenAccessError"
      *     }
      */

     /**
      * @apiDefine AuthorFieldsSuccess
      *
      * @apiSuccess {Integer} id User ID of the Author
      * @apiSuccess {String} name Name of the Author
      * @apiSuccess {String} email E-mail of the Author
      * @apiSuccess {String} github Github link of the Author
      * @apiSuccess {String} twitter Twitter Handle of the Author
      * @apiSuccess {String} location Location of the Author
      * @apiSuccess {String} latest_article_published Title of the last article publihed by the author
      * @apiSuccess {DateTime} created_at Timestamp when the row was created
      * @apiSuccess {DateTime} updated_at Timestamp when the row was updated
      */
    /**
     * @api {get} /authors/ Get all authors from the authors table
     * @apiName showAllAuthors
     * @apiGroup authors
     *
     * @apiUse AuthorFieldsSuccess
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 4,
     *         "name": "John Doe",
     *         "email": "john.doe@email.com",
     *         "github": "github.com/john",
     *         "twitter": "johndoe",
     *         "location": "NewYork",
     *         "latest_article_published": "How to make an API documentation ",
     *         "created_at": "2018-10-19 03:29:50",
     *         "updated_at": "2018-10-19 03:29:50"
     *     }
     *
     * @apiUse ForbiddenAccessError
     */
    public function showAllAuthors()
    {
        return response()->json(Author::all());
    }
    /**
     * @api {get} /authors/:id Request information of one author
     * @apiName showOneAuthor
     * @apiGroup authors
     *
     * @apiParam {Integer} id Authors unique ID.
     *
     * @apiUse AuthorFieldsSuccess
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 4,
     *         "name": "John Doe",
     *         "email": "john.doe@email.com",
     *         "github": "github.com/john",
     *         "twitter": "johndoe",
     *         "location": "NewYork",
     *         "latest_article_published": "How to make an API documentation ",
     *         "created_at": "2018-10-19 03:29:50",
     *         "updated_at": "2018-10-19 03:29:50"
     *     }
     *
     * @apiUse ForbiddenAccessError
     * @apiUse AuthorNotFoundError
     */
    public function showOneAuthor($id)
    {
        return response()->json(Author::find($id));
    }

    /**
     * @api {post} /authors/ Insert an author
     * @apiName create
     * @apiGroup authors
     *
     * @apiParam {String} name Name of the Author [Required]
     * @apiParam {String} email E-mail of the Author [Required]
     * @apiParam {String} github Github link of the Author
     * @apiParam {String} twitter Twitter Handle of the Author
     * @apiParam {String} location Location of the Author [Required]
     * @apiParam {String} latest_article_published Title of the last article publihed by the author
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *         "id": 4,
     *         "name": "John Doe",
     *         "email": "john.doe@email.com",
     *         "github": "github.com/john",
     *         "twitter": "johndoe",
     *         "location": "NewYork",
     *         "latest_article_published": "How to make an API documentation ",
     *     }
     *
     * @apiUse AuthorFieldsSuccess
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 201 Created
     *     {
     *         "id": 4,
     *         "name": "John Doe",
     *         "email": "john.doe@email.com",
     *         "github": "github.com/john",
     *         "twitter": "johndoe",
     *         "location": "NewYork",
     *         "latest_article_published": "How to make an API documentation ",
     *         "created_at": "2018-10-19 03:29:50",
     *         "updated_at": "2018-10-19 03:29:50"
     *     }
     *
     * @apiUse ForbiddenAccessError
     * @apiUse MethodNotAllowedError
     * @apiError MissingFieldsError
     *
     * @apiErrorExample Missing Fields:
     *     HTTP/1.1 422 Unprocessable Entity
     *     {
     *         "name": [
     *            "The name field is required."
     *         ],
     *         "email": [
     *            "The email field is required."
     *         ],
     *         "location": [
     *             "The location field is required."
     *         ]
     *     }
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'location' => 'required|alpha'
        ]);

        $author = Author::create($request->all());

        return response()->json($author, 201);
    }

    /**
     * @api {put} /authors/:id Update the information of an author
     * @apiName showOneAuthor
     * @apiGroup authors
     *
     * @apiParam {Integer} id ID of the author to be updated
     * @apiParam {String} name Name of the Author
     * @apiParam {String} email E-mail of the Author
     * @apiParam {String} github Github link of the Author
     * @apiParam {String} twitter Twitter Handle of the Author
     * @apiParam {String} location Location of the Author
     * @apiParam {String} latest_article_published Title of the last article publihed by the author
     *
     * @apiParamExample {json} Request-Example:
     *     {
     *         "id": 4,
     *         "name": "John Doe",
     *         "email": "john_doe@email.com",
     *         "github": "github.com/john",
     *         "twitter": "johndoe",
     *         "location": "NewYork",
     *         "latest_article_published": "How to make an API documentation ",
     *     }
     *
     * @apiUse AuthorFieldsSuccess
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "id": 4,
     *         "name": "John Doe",
     *         "email": "john_doe@email.com",
     *         "github": "github.com/john",
     *         "twitter": "johndoe",
     *         "location": "NewYork",
     *         "latest_article_published": "How to make an API documentation ",
     *         "created_at": "2018-10-19 03:29:50",
     *         "updated_at": "2018-10-19 03:40:23"
     *     }
     *
     * @apiUse ForbiddenAccessError
     * @apiUse MethodNotAllowedError
     */

    public function update($id, Request $request)
    {
        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, 200);
    }

    /**
     * @api {delete} /authors/:id Delete an author
     * @apiName delete
     * @apiGroup authors
     *
     * @apiParam {Integer} id ID of the author to be deleted
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         Deleted successfully
     *     }
     *
     * @apiUse ForbiddenAccessError
     * @apiUse MethodNotAllowedError
     */

    public function delete($id)
    {
        Author::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
