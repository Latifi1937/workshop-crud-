<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API Gestion des Articles",
 *      description="Documentation de l'API pour la gestion des articles",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 * @OA\Server(
 *      url="http://127.0.0.1:8000",
 *      description="Serveur local"
 * )
 */
class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/articles",
     *     summary="Récupérer la liste des articles",
     *     tags={"Articles"},
     *     @OA\Response(response="200", description="Liste des articles récupérée avec succès")
     * )
     */
    public function index()
    {
        $articles = Article::all();
        return response()->json($articles, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/articles",
     *     summary="Créer un nouvel article",
     *     tags={"Articles"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","description"},
     *             @OA\Property(property="title", type="string", example="Mon premier article"),
     *             @OA\Property(property="description", type="string", example="Ceci est une description")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Article créé avec succès"),
     *     @OA\Response(response="422", description="Erreur de validation")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $article = Article::create($validatedData);
        return response()->json($article, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/articles/{id}",
     *     summary="Afficher un article spécifique",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'article",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Détails de l'article"),
     *     @OA\Response(response="404", description="Article non trouvé")
     * )
     */
    public function show(Article $article)
    {
        return response()->json($article, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/articles/{id}",
     *     summary="Mettre à jour un article",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'article",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","description"},
     *             @OA\Property(property="title", type="string", example="Titre mis à jour"),
     *             @OA\Property(property="description", type="string", example="Description mise à jour")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Article mis à jour avec succès"),
     *     @OA\Response(response="422", description="Erreur de validation"),
     *     @OA\Response(response="404", description="Article non trouvé")
     * )
     */
    public function update(Request $request, Article $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $article->update($validatedData);
        return response()->json($article, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/articles/{id}",
     *     summary="Supprimer un article",
     *     tags={"Articles"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'article",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Article supprimé avec succès"),
     *     @OA\Response(response="404", description="Article non trouvé")
     * )
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}
