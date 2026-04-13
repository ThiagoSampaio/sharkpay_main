ints;
  }

  /// The [ui.FlutterView] into which this [RenderView] will render.
  ui.FlutterView get flutterView => _view;
  final ui.FlutterView _view;

  /// Whether Flutter should automatically compute the desired system UI.
  ///
  /// When this setting is enabled, Flutter will hit-test the layer tree at the
  /// top and bottom of the screen on each frame looking for an
  /// [AnnotatedRegionLayer] with an instance of a [SystemUiOverlayStyle]. The
  /// hit-test result from the top of the screen provides the status bar settings
  /// and the hit-test result from the bottom of the screen provides the system
  /// nav bar settings.
  ///
  /// If there is no [AnnotatedRegionLayer] on the bottom, the hit-test result
  /// from the top provides the system nav bar settings. If there is no
  /// [AnnotatedRegionLayer] on the top, the hit-test result from the bottom
  /// provides the system status bar settings.
  ///
  /// Setting this to false does not cause previous automatic adjustments to be
  /// reset, nor does setting it to true cause the app to update immediately.
  ///
  /// If you want to imperatively set the system ui style instead, it is
  /// recommended that [automaticSystemUiAdjustment] is set to false.
  ///
  /// See also:
  ///
  ///  * [AnnotatedRegion], for placing [SystemUiOverlayStyle] in the layer tree.
  ///  * [SystemChrome.setSystemUIOverlayStyle], for imperatively setting the system ui style.
  bool automaticSystemUiAdjustment = true;

  /// Bootstrap the rendering pipeline by preparing the first frame.
  ///
  /// This should only be called once. It is typically called immediately after
  /// setting the [configuration] the first time (whether by passing one to the
  /// constructor, or setting it directly). The [configuration] must have been
  /// set before calling this method, and the [RenderView] must have been
  /// attached to a [PipelineOwner] using [attach].
  ///
  /// This does not actually schedule the first frame. Call
  /// [PipelineOwner.requestVisualUpdate] on the [owner] to do that.
  ///
  /// This should be called before using any methods that rely on the [layer]
  /// being initialized, such as [compositeFrame].
  ///
  /// This method calls [scheduleInitialLayout] and [scheduleInitialPaint].
  void prepareInitialFrame() {
    assert(
      owner != null,
      'attach the RenderView to a PipelineOwner before calling prepareInitialFrame',
    );
    assert(
      _rootTransform == null,
      'prepareInitialFrame must only be called once',
    ); // set by _updateMatricesAndCreateNewRootLayer
    assert(hasConfiguration, 'set a configuration before calling prepareInitialFrame');
    scheduleInitialLayout();
    scheduleInitialPaint(_updateMatricesAndCreateNewRootLayer());
    assert(_rootTransform != null);
  }

  Matrix4? _rootTransform;

  TransformLayer _updateMatricesAndCreateNewRootLayer() {
    assert(hasConfiguration);
    _rootTransform = configuration.toMatrix();
    final TransformLayer rootLayer = TransformLayer(transform: _rootTransform);
    rootLayer.attach(this);
    assert(_rootTransform != null);
    return rootLayer;
  }

  // We never call layout() on this class, so this should never get
  // checked. (This class is laid out using scheduleInitialLayout().)
  @override
  void debugAssertDoesMeetConstraints() {
    assert(false);
  }

  @override
  void performResize() {
    assert(false);
  }

  @override
  void performLayout() {
    assert(_rootTransform != null);
    final bool sizedByChild = !constraints.isTight;
    child?.layout(constraints, parentUsesSize: sizedByChild);
    _size = sizedByChild && child != null ? child!.size : constraints.smallest;
    assert(size.isFinite);
    assert(constraints.isSatisfiedBy(size));
  }

  /// Determines the set of render objects located at the given position.
  ///
  /// Returns true if the given point is contained in this render object or one
  /// of its descendants. Adds any render objects that contain the point to the
  /// given hit test result.
  ///
  /// The [position] argument is in the coordinate system of the render view,
  /// which is to say, in logical pixels. This is not necessarily the same
  /// coordinate system as that expected by the root [Layer], which will
  /// normally be in physical (device) pixels.
  bool hitTest(HitTestResult result, {required Offset position}) {
    child?.hitTest(BoxHitTestResult.wrap(result), position: position);
    result.add(HitTestEntry(this));
    return true;
  }

  @override
  bool get isRepaintBoundary => true;

  @override
  void paint(PaintingContext context, Offset offset) {
    if (child != null) {
      context.paintChild(child!, offset);
    }
    assert(() {
      final List<DebugPa