<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Message;
use App\Models\ResponseType;
use App\Models\Source;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\PregReplace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PregReplaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_response_type()
    {

        $example = <<<EOD
A user is asking you questions about the regulatory rules related to California Regional Water Quality Control Board Central Valley Region that has been uploaded to this database. Please answer there questions from the context below and only reference external information if needed.
Context: Attach D Order R5-201 3-0120 -09 37 Tular Lake Basin Area Septemb 2013 Revis April 20 21 Refer Cite California Depart Conservation, Divis Land Resourc Protection. 2006. 2002 2004 Farmland Convers Report. Farmland Map Monitor Program. Californi Depart Conservation, Divis Land Resourc e Protection. 2008. 2004 2006 Farmland Convers Report. Farmland Map Monitor Program. California Depart Justice. 2008. California Environment Qualiti Act: Address Global Warm Impact Local Agenc Level. revised: Decemb 9, 2008. Available: <http://www.ag.ca.gov/globalwarming/pdf/gw_mitigation_measures.pdf>. Accessed: Septemb 25, 2009. Central Valley Region Water Qualiti Contro l Board. 2005. Amend Water Qualiti Control Plan Sacramento River San Joaquin River Basin Control Program Factor Contribut Dissolv Oxygen Impair t Stockton Deep Water Ship Channel. Final staff repor t. Februari 23. Central Valley Region Water Qualiti Control Board. 2011. Recommend Irrig Land Regula tori Program Framework Staff Report. March. Rancho Cordova, Ca. Available: <http://www.waterboards.ca.gov/centralvalley/water_issues/irrigated_lands/long_term_progr am_development/recomnd_framewk_mar2011.pdf>. Icf International. 2011. Irrig Land Regulatori Program Program Environment Impact Report. Final Draft. March. ( Icf 05508.05.) Sacramento, Ca. Prepar Central Valley Region Water Qualiti Control Board, Sacramento, Ca. Icf Internatio nal. 2010. Draft Technic Memorandum Concern Econom Analysi Irrig Land Regulatori Program. July. (icf 05508.05.) Sacramento, Ca. Prepar Central Valley Region Water Qualiti Control Board, Sacramento, Ca. Available: <http://www.swrcb.ca.gov/centralvalley/water_issues/irrigated_lands/long_term_program_d velopment>. Lehman, P.w., J. Sevier, J. Giulianotti, M. Johnso n. 2004. Sourc Oxygen Demand Lower San Joaquin River, California. Estuari 27(3): 405 418. Mason, L.b., C. Amrhein, C. C. Goodson, M. R. Matsumoto, M. A. Anderson. 2005. Reduc Sediment Phosphorus Tributari Water Alum Po lyacrylamide. Journal Environment Qualiti 34: 1998 2004. Sojka, R.e., R.d. Lentz, I. Shainberg, T.j. Trout, C.w. Ross, C.w. Robbins, J.a. Entry, J.k. Aase, D.l. Bjorneberg, W.j. Orts, D.t. Westermann, D.w. Morishita, M.e. Watwood, T.l. Spofford, F.w. Barvenik. 2000. Irrig polyacrylamid (pam): year million acr experi. P. 161169 R.g. Evans, B.l. Benham, T.p. Trooien (eds.). Proceed Nation Irrig Symposium, 4th Decenni Symposium, Phoenix, Arizona, 14 16 Novemb 2000. Public 701p0004. St Joseph, Mi: American Societi Agricultur Engineers. Attach E Order R5 -2013 -0120 -0 9 11 Tular Lake Basin Area Septemb 2013 Revis April 2021 Nrcs Natur Resourc Conserv Ser vice Nrhp Nation Regist Histor Place Ntr Nation Toxic Rule Pam polyacrylamid Pcpa Pesticid Contamin Prevent Act Peir Long-term Irrig Land Regulatori Program Final Program Eir (final Draft) (certifi Resolut R5 -2011 -0017) Prc California Public Resourc es Code Pur pesticid use report, CA Dpr Qapp qualiti assur project plan Qa/qc qualiti assur qualiti control Rcd Resourc Conserv District RL report limit Rwd report wast discharg SB Senat Sip Polici Implement Toxic Standard Inland Surfac Waters, Enclos Bays, Estuari CA (state Implement Plan) Sqmp surfac water qualiti manag plan State Water Board State Water Resourc Control Board Swamp surfac water ambient monitor program Tac toxic air contamin Tds total dissolv solid Tie toxic identif evalu Tmdl total maximum daili load Toc total organ carbon Trs township, range, section Tss total suspend solid Tst test signific toxic (usepa method) Usac U.s. Armi Corp Engin Usepa U.s. Environment Protect Agenc Usfw U.s. Fish Wildlif Servic Wdrs wast discharg requir s Wast Discharg Requir General Order R5 -2013 -0120 -09 ii Grower Tular Lake Basin Area Septemb 2013 Revis April 2021 D. Templat....................................................................................................................... 41 E. Annual Report Manag Practic Implement Nitrogen Applic....... 41 F. Groundwat Qualiti Monitor Protect............................................................. 41 G. Surfac Water Monitor Plan....................................................................................... 43 H. Sediment Discharg Eros Assess Report................................................... 43 I. Surfac Water Exceed port............................................................................... 43 J. Monitor Report........................................................................................................... 44 K. Nitrat Control Program Earli Action Plan................................................................. 44 L. Nitrat Control Program Initi Assess (path Only)......................................... 44 M. Nitrat Control Program Preliminari Manag Zone Proposals, Final Ma nagement Proposals, Manag Zone Implement Plan (path B Only)........................... 44 N. Surfac Water/groundwat Qualiti Manag Plan (sqmp/gqmp)....................... 44 O. Technic Report........................................................................................................... 47 P. Notic Termin...................................................................................................... 47 Q. Total Maximum Daili L oad (tmdl) Requir......................................................... 47 R. Basin Plan Amend Workplan.................................................................................. 47 Ix. Report Provis............................................................................................................ 48 X. Record -keep Requir............................................................................................. 49 Xi. Annual Fee......................................................................................................................... 49 Xii. Time Schedul Complianc............................................................................................ 49 Figur 1 Map Tular Lake Basin Area.......................................................................... 51 Tabl 1 Member date requir report...................................................................... 52 Tabl 2 Third- Parti date requir report.................................................................. 52 Attach A: Inform Sheet Attach B: Monitor Report Program Order (contain appendices) Attach C: Ceqa Mitig Measur Attach D: Find Fact Statement Overrid Consider Attach E: Definitions, Acronyms, Abbreviati on
EOD;

        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        DocumentChunk::factory()->count(10)->create([
                'document_id' => $document->id,
                'content' => $example,
            ]
        );

        $documents = DocumentChunk::query()
            ->where('content', 'LIKE', $example)->get();

        $message = Message::factory()->create();

        $responseDto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::from([
                'contents' => Content::collection($documents),
            ]),
        ]);

        $responseType = ResponseType::factory()
            ->pregReplace()
            ->create();

        $trim = new PregReplace($source->project, $responseDto);

        $results = $trim->handle($responseType);

        $this->assertStringNotContainsString("..", $results->response->contents->first()->content);
        $this->assertStringNotContainsString("''", $results->response->contents->first()->content);
    }
}
