<?php
namespace App\Controller;
use App\Entity\Users;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;

class LuckyController extends AbstractController
{
    private $formFactory;
    private $entityManager;
    private $router;
    private $flashBag;
    public function __construct(FormFactoryInterface $formFactory,EntityManagerInterface $entityManager,RouterInterface $router,FlashBagInterface $flashBag){
        $this->formFactory=$formFactory;
        $this->entityManager=$entityManager;
        $this->router=$router;
        $this->flashBag=$flashBag;
    }
    /**
     * @Route("/", name="Page_1")
     */
    public function Page_1(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Users::class);
        $users=$repository->findAll();
        return $this->render('page1.html.twig',['users'=>$users]);
    }

    /**
     * @Route("/user/{id}", name="user")
     */
    public function show($id): Response
    {
        $repository=$this->getDoctrine()->getRepository(Users::class);
        $user=$repository->find($id);
        return $this->render('user.html.twig',['user'=>$user]);
    }

    /**
     * @Route("/add", name="add_user")
     */
    public function add(Request $request ){
        $user=new Users();
        $form = $this->formFactory->create(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return new RedirectResponse(
                $this->router->generate("Page_1")
            );
        };
        return $this->render('add.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @Route("/edit/{id}", name="edit_user")
     */
    public function edit($id , Request $request ){
        $repository=$this->getDoctrine()->getRepository(Users::class);
        $user=$repository->find($id);
        $form = $this->formFactory->create(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush();
            return new RedirectResponse(
                $this->router->generate("Page_1")
            );
        };
        return $this->render('edit.html.twig',['form'=>$form->createView()]);

    }

    /**
     * @Route("/delet/{id}", name="delet_user")
     */
    public function delet($id){
        $repository=$this->getDoctrine()->getRepository(Users::class);
        $user=$repository->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        $this->flashBag->add('notice','user has been removed succefuly');
        return new RedirectResponse(
            $this->router->generate("Page_1")
        );
    }
}