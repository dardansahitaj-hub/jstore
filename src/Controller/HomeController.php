<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoArticle;

    public function __construct(ArticleRepository $repoArticle)
    {
        $this->repoArticle = $repoArticle;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $repoCategory): Response
    {
        // //Récupérer toutes les données de la BDD
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        // Mit en commentaire car les paramètres on été mit directement dans la function index

        $categories = $repoCategory->findAll();
        $articles = $this->repoArticle->findAll(); //findAll pour récupérer toutes les données

        return $this->render("home/index.html.twig", [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article): Response
    {
        //Récupérer un article de la BDD
        // $repo = $this->getDoctrine()->getRepository(Article::class);

        // $article = $this->repoArticle->find($id); //find pour chercher uniquement une entré

        if (!$article) {
            return $this->redirectToRoute('home');
        }

        return $this->render("show/index.html.twig", [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/showArticle/{id}", name="show_article")
     */
    public function showArticle(Category $category): Response
    {
        $articles = $category->getArticles();

        return $this->render("show/showArticle.html.twig");
    }
}
