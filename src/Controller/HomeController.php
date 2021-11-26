<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var ArticleRepository
     * @var CategoryRepository
     */
    private $repoArticle;
    private $repoCategory;

    public function __construct(ArticleRepository $articleRepository, CategoryRepository $repoCategory)
    {
        $this->repoArticle = $articleRepository;
        $this->repoCategory = $repoCategory;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $categories = $this->repoCategory->findAll();
        $articles = $this->repoArticle->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/show/{id<[0-9]+>}", name="show")
     */
    public function show(Article $article): Response
    {
        return $this->render('show/index.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/showArticles/{id<[0-9]+>}", name="show_article")
     */
    public function showArticleByCategory(?Category $category): Response
    {

        if ($category) {
            $articles = $category->getArticles()->getValues();
        } else {
            return $this->redirectToRoute('home');
        }
        $categories = $this->repoCategory->findAll();
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);

    }
}
