<footer class="footer">
    <div class="container-fluid">
        <div class="hospital-footer-layout">
            <div>
                <strong>© Hospital San Juan de Dios {{ date('Y') }} — Portal de Aplicaciones Hospitalarias</strong>
            </div>
            <div class="hospital-visit-counter" aria-label="Total de visitas al portal">
                <i class="mdi mdi-eye-outline" aria-hidden="true"></i>
                <span>Visitas</span>
                <strong>{{ isset($visitTotal) ? number_format($visitTotal, 0, ',', '.') : '—' }}</strong>
            </div>
            <div>
                <div class="text-sm-end">
                    <strong>
                        Diseñado y Desarrollado por Unidad de Transformación Digital
                        <a href="http://hsjd.redsalud.gob.cl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-decoration-underline">
                            HSJD
                        </a>
                    </strong>
                </div>
            </div>
        </div>
    </div>
</footer>
