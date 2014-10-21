<?php
 
namespace Tricks\Repositories\Eloquent;

use Disqus;
use Tricks\Tag;
use Tricks\Ciudad;
use Tricks\User;
use Tricks\Trick;
use Tricks\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Tricks\Services\Forms\TagForm;
use Tricks\Services\Forms\TrickForm;
use Tricks\Services\Forms\TrickEditForm;
use Tricks\Services\Forms\TagEditForm;
use Tricks\Exceptions\TagNotFoundException;
use Tricks\Exceptions\CiudadNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Tricks\Exceptions\CategoryNotFoundException;
use Tricks\Repositories\TrickRepositoryInterface;
use Tricks\Repositories\TagRepositoryInterface;

class TagRepository extends AbstractRepository implements TagRepositoryInterface
{
    /**
     * Create a new DbTagRepository instance.
     *
     * @param  \Tricks\Tag $tags
     * @return void
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll()
    {
        $tags = $this->model->lists('spanish_name', 'id');

        return $tags;
    }

    /**
     * Find all tags.
     *
     * @param  string  $orderColumn
     * @param  string  $orderDir
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function findAll($orderColumn = 'created_at', $orderDir = 'desc')
    {
        $tags = $this->model
                     ->orderBy($orderColumn, $orderDir)
                     ->get();

        return $tags;
    }

    /**
     * Find a tag by id.
     *
     * @param  mixed  $id
     * @return \Tricks\Tag
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

        /**
     * Find all the tags paginated.
     *
     * @param  integer $perPage
     * @return \Illuminate\Pagination\Paginator|\Tricks\Tag[]
     */
    public function BuscaTodosPaginado($perPage = 3)
    {
        $tags = $this->model->paginate($perPage);

        return $tags;
    }

    /**
     * Get a list of tag ids that are associated with the given trick.
     *
     * @param  \Tricks\Trick $trick
     * @return array
     */
    public function listTagsIdsForTrick(Tag $trick)
    {
        return $trick->tags->lists('id');
    }

    /**
     * Find all tricks order by the creation date paginated.
     *
     * @param  integer $per_page
     * @return \Illuminate\Pagination\Paginator|\Tricks\Trick[]
     */
    public function listarPorPagina($per_page = 6)
    {
        return $this->paginate($per_page = 6);
    }

    /**
     * Find all tags with the associated number of tricks.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Tricks\Tag[]
     */
    public function findAllWithTrickCount($per_page=10)
    {
       /* return $this->model
                    ->leftJoin('tag_trick', 'tags.id', '=', 'tag_trick.tag_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'tag_trick.trick_id')
                    ->groupBy('tags.slug')
                    ->orderBy('trick_count', 'desc')

                    ->get([
                        'tags.name',
                        'tags.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ]);
        
       */
        $tags = $this->model
                    ->select('tags.name','tags.spanish_name','tags.slug',DB::raw('COUNT(tricks.id) as trick_count'))
                    ->leftJoin('tag_trick', 'tags.id', '=', 'tag_trick.tag_id')
                    ->leftJoin('tricks', 'tricks.id', '=', 'tag_trick.trick_id')
                    ->groupBy('tags.slug')
                    ->orderBy('trick_count', 'desc')
                    
                    ->paginate($per_page)
                    /*->get([
                        'tags.name',
                        'tags.slug',
                        DB::raw('COUNT(tricks.id) as trick_count')
                    ])*/
                    ;
                    

        return $tags;



    }

    /**
     * Find a tags by the given slug.
     *
     * @param  string $slug
     * @return \Tricks\Tag
     */
    public function findBySlug($slug)
    {
        return $this->model->whereSlug($slug)->first();
    }

    /**
     * Create a new tag in the database.
     *
     * @param  array  $data
     * @return \Tricks\Tag
     */
    public function create(array $data)
    {
        $tag = $this->getNew();

        $tag->name = $data['name'];
        $tag->slug = Str::slug($tag->name, '-');
        $tag->spanish_name = $data['spanish_name'];
        $tag->iso2 = $data['iso2'];

        $tag->save();

        return $tag;
    }

    /**
     * Update the tag in the database.
     *
     * @param  \Tricks\Tag $tag
     * @param  array $data
     * @return \Tricks\Tag
     */
    public function edit(Tag $tag, array $data)
    {
        //$tag->user_id = $data['user_id'];
        $tag->name       = e($data['name']);
        $tag->slug        = Str::slug($data['slug'], '-');
        $tag->spanish_name = e($data['spanish_name']);
        $tag->iso2 = e($data['iso2']);
        //$tag->code        = $data['code'];

        $tag->save();

        //$tag->tags()->sync($data['tags']);
        //$tag->ciudades()->sync($data['ciudades']);
        //$tag->categories()->sync($data['categories']);

        return $tag;
    }

    /**
     * Update the specified tag in the database.
     *
     * @param  mixed  $id
     * @param  array  $data
     * @return \Tricks\Category
     */
    public function update($id, array $data)
    {
        $tag = $this->findById($id);

        $tag->name = $data['name'];
        $tag->slug = Str::slug($tag->name, '-');

        $tag->save();

        return $tag;
    }

    /**
     * Delete the specified tag from the database.
     *
     * @param  mixed  $id
     * @return void
     */
    public function delete($id)
    {
        $tag = $this->findById($id);

        $tag->tricks()->detach();

        $tag->delete();
    }

    /**
     * Get the tag create/update form service.
     *
     * @return \Tricks\Services\Forms\TagForm
     */
    public function getForm()
    {
        return new TagForm;
    }
    /**
     * Get the tag creation form service.
     *
     * @return \Tricks\Services\Forms\TrickForm
     */
    public function getCreationForm()
    {
        return new TagForm;
    }

    /**
     * Get the tag edit form service.
     *
     * @return \Tricks\Services\Forms\TagEditForm
     */
    public function getEditForm($id)
    {
        return new TagEditForm($id);
    }
}
