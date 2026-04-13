<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use DB;

class CoursesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Cursos com acesso ativo
        $courses = DB::table('product_access')
            ->join('products', 'product_access.product_id', '=', 'products.id')
            ->join('courses', 'products.id', '=', 'courses.product_id')
            ->leftJoin('users as instructors', 'courses.instructor_id', '=', 'instructors.id')
            ->where('product_access.user_id', $user->id)
            ->where('product_access.status', 'active')
            ->where('courses.status', 'published')
            ->select(
                'courses.*',
                'products.name as product_name',
                'products.thumbnail',
                'products.amount',
                'instructors.name as instructor_name',
                'product_access.granted_at',
                'product_access.access_type'
            )
            ->orderBy('product_access.granted_at', 'desc')
            ->paginate(12);

        // Estatísticas
        $stats = [
            'total_courses' => DB::table('product_access')
                ->join('courses', 'product_access.product_id', '=', 'courses.product_id')
                ->where('product_access.user_id', $user->id)
                ->where('product_access.status', 'active')
                ->count(),
            'completed_courses' => 0, // Implementar sistema de progresso
            'in_progress' => 0, // Implementar sistema de progresso
            'total_hours' => DB::table('product_access')
                ->join('courses', 'product_access.product_id', '=', 'courses.product_id')
                ->where('product_access.user_id', $user->id)
                ->where('product_access.status', 'active')
                ->sum('courses.duration_hours')
        ];

        return view('customer.courses.index', compact('courses', 'stats', 'lang'));
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Verificar acesso
        $access = DB::table('product_access')
            ->join('courses', 'product_access.product_id', '=', 'courses.product_id')
            ->where('product_access.user_id', $user->id)
            ->where('courses.id', $id)
            ->where('product_access.status', 'active')
            ->first();

        if (!$access) {
            return redirect()->route('customer.courses.index')
                ->with('error', 'Você não tem acesso a este curso.');
        }

        // Buscar curso completo
        $course = DB::table('courses')
            ->join('products', 'courses.product_id', '=', 'products.id')
            ->leftJoin('users as instructors', 'courses.instructor_id', '=', 'instructors.id')
            ->where('courses.id', $id)
            ->select(
                'courses.*',
                'products.name as product_name',
                'products.description as product_description',
                'products.thumbnail',
                'instructors.name as instructor_name',
                'instructors.email as instructor_email'
            )
            ->firstOrFail();

        // Aulas do curso (simulado - implementar tabela course_lessons)
        $lessons = [];

        // Progresso do aluno (simulado - implementar tabela course_progress)
        $progress = [
            'completed_lessons' => 0,
            'total_lessons' => $course->total_lessons,
            'percentage' => 0,
            'last_lesson' => null
        ];

        return view('customer.courses.show', compact('course', 'lessons', 'progress', 'lang'));
    }

    public function lesson($courseId, $lessonId)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Verificar acesso ao curso
        $access = DB::table('product_access')
            ->join('courses', 'product_access.product_id', '=', 'courses.product_id')
            ->where('product_access.user_id', $user->id)
            ->where('courses.id', $courseId)
            ->where('product_access.status', 'active')
            ->first();

        if (!$access) {
            abort(403, 'Acesso negado a este curso.');
        }

        $course = DB::table('courses')->where('id', $courseId)->firstOrFail();

        // Buscar aula (simulado - implementar tabela course_lessons)
        $lesson = [
            'id' => $lessonId,
            'title' => 'Aula ' . $lessonId,
            'description' => 'Descrição da aula',
            'video_url' => $course->video_url,
            'duration' => '15:30',
            'content' => 'Conteúdo da aula em HTML'
        ];

        // Próxima aula
        $nextLesson = null;

        // Aula anterior
        $previousLesson = null;

        return view('customer.courses.lesson', compact('course', 'lesson', 'nextLesson', 'previousLesson', 'lang'));
    }

    public function completeLesson(Request $request, $courseId, $lessonId)
    {
        $user = Auth::user();

        // Implementar lógica de marcar aula como completa
        // Criar tabela course_progress se não existir

        return response()->json([
            'success' => true,
            'message' => 'Aula marcada como completa!'
        ]);
    }

    public function certificate($courseId)
    {
        $user = Auth::user();

        // Verificar se completou o curso
        $course = DB::table('courses')->where('id', $courseId)->firstOrFail();

        // Verificar progresso (implementar)
        $completed = false; // Verificar se completou todas as aulas

        if (!$completed) {
            return back()->with('error', 'Complete todas as aulas para gerar o certificado.');
        }

        // Gerar certificado
        return view('customer.courses.certificate', compact('course', 'user'));
    }
}
