<?php

namespace App\Controller;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StudentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }
#[Route('/fetch', name:'fetch')]
    public function fetch(StudentRepository $repo): Response{
$result = $repo-> findAll();
return $this->render('student/test.html.twig',[
'response' => $result,
]);

    }

#[Route('/add', name:'add')]
public function add(ManagerRegistry $mr): Response{


    $S = new student();
    $S->setName('test');
    $S->setEmail('test@gmail.com');
    $S->setAge('25');

    $em=$mr->getManager();
    $em->persist($S);
    $em->flush();

    return $this->redirectToRoute('fetch');
   }

   #[Route('/remove/{id}', name: 'remove')]
    public function remove(StudentRepository $repo , $id, ManagerRegistry $mr): Response
    {
        $student=$repo->find($id);
        $em=$mr->getManager();
        $em->remove($student);
        $em->flush(); 

        return $this->redirectToRoute('fetch');
    }

    #[Route('/add1', name: 'add1')]
    public function add1(Request $request, ManagerRegistry $mr ):Response 
    {
        $student=new student();
        $form=$this-> CreateForm(StudentType::class,$student);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$mr->getManager();
            $em->persist($student);
            $em->flush();

            return $this-> redirectToRoute('fetch');
        }
        return $this ->render('student/form.html.twig',[
            'f'=>$form-> CreateView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function modifier(StudentRepository $repo ,$id, Request $request, ManagerRegistry $mr): Response
    {
        $s=$repo->find($id);
        $form=$this-> CreateForm(StudentType::class,$s);
        $form->add('Modifier', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em=$mr->getManager();
            $em->persist($s);
            $em->flush();

            return $this-> redirectToRoute('fetch');
        }
        return $this ->render('student/form.html.twig',[
            'f'=>$form-> CreateView()
        ]);
    }
}
